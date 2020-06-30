<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_App_Profiler
{
	private $benchmark = NULL;
	protected $_available_sections = array(
		'memory_usage',
		'factory',
		'queries',
		'events',
		'get',
		'post',
		'http_headers',
		'session_data',
		'config',
		'benchmarks',
		);

	protected $_query_toggle_count = 25;

	protected $queries = array();
	protected $lastQuery = array();
	protected $events = array();

	protected $factoryStack = array();
	protected $factory = array();

	public function __construct()
	{
		$this->benchmark = new HC4_Profiler_Benchmark;
		$this->markStart( 'total' );

		// default all sections to display
		foreach ($this->_available_sections as $section){
			if ( ! isset($config[$section])){
				$this->_compile_{$section} = TRUE;
			}
		}
	}

	public function markFactoryStackStart( $name )
	{
		$this->factoryStack[] = $name;
		$fullName = join( '/', $this->factoryStack );

		if( ! isset($this->factory[$fullName]) ){
			$this->factory[$fullName] = array( 0, 0 );
		}

		$this->factory[$fullName][0] -= microtime( TRUE );
		$this->factory[$fullName][1] += 1;

		$this->benchmark->markStart( '__factory:' . $name );

		// echo __FUNCTION__ . ': ' . $fullName . '<br>';
	}

	public function markFactoryStackEnd()
	{
		$fullName = join( '/', $this->factoryStack );

		if( isset($this->factory[$fullName]) ){
			$this->factory[$fullName][0] += microtime( TRUE );

			$name = array_pop( $this->factoryStack );
			$this->benchmark->markEnd( '__factory:' . $name );
		}

		return $this;
	}

	public function markEvent( $event, $handler )
	{
		$this->events[] = array( $event, $handler );
		return $this;
	}

	public function markFactory( $className )
	{
		$this->factory[] = $className;
		return $this;
	}

	public function markQueryStart( $sql )
	{
		$start = microtime( TRUE );
		$this->lastQuery = array( $sql, $start );
	}

	public function markQueryEnd()
	{
		$end = microtime( TRUE );
		$this->lastQuery[1] = $end - $this->lastQuery[1];
		$this->queries[] = $this->lastQuery;
	}

	public function markStart( $name )
	{
		$this->benchmark->markStart( $name );
		return $this;
	}

	public function markEnd( $name )
	{
		$this->benchmark->markEnd( $name );
		return $this;
	}

	public function set_sections($config)
	{
		foreach ($config as $method => $enable){
			if (in_array($method, $this->_available_sections)){
				$this->_compile_{$method} = ($enable !== FALSE) ? TRUE : FALSE;
			}
		}
	}

	protected function _compile_benchmarks()
	{
		$profile = array();

		foreach( $this->benchmark->getMarkers() as $key ){
			if( '__factory:' == substr($key, 0, strlen('__factory:')) ){
				continue;
			}
			$profile[ $key ] = array( $this->benchmark->getTime($key), $this->benchmark->getCount($key) );
		}

		// uasort( $profile, function($a, $b){
			// if( $b[0] > $a[0] ){
				// return 1;
			// }
			// elseif( $b[0] < $a[0] ){
				// return 0;
			// }
			// else {
				// return -1;
			// }
		// });

		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_benchmarks" style="border:1px solid #900;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#900;">&nbsp;&nbsp;'.'profiler_benchmarks'.'&nbsp;&nbsp;</legend>';
		$output .= "\n";
		$output .= "\n\n<table style='width:100%;'>\n";

		$decimals = 4;
		$total = $profile['total'][0];
		reset( $profile );
		foreach( $profile as $key => $val ){
			list( $val, $qty ) = $val;

			$valView = number_format( $val, $decimals );

			$valPercent = $val / $total;

			$valPercentView = $valPercent * 100;
			$valPercentView = number_format( $valPercentView, 2 );
			$valPercentView .= '%';

			$profile[ $key ] = array( $valView, $qty, $valPercent, $valPercentView );
		}

		$threshold = 3 / count($profile);

		foreach( $profile as $key => $val ){
			list( $val, $qty, $valPercent, $valPercentView ) = $val;
			// $key = ucwords(str_replace(array('_', '-'), ' ', $key));
			// $key = str_replace(array('_', '-'), ' ', $key);
			$color = ( $valPercent > $threshold ) ? '#900' : '#999';

			$output .= "
				<tr>
				<td style='border:#bbb 1px solid;padding:2px;width:50%;color:#000;font-weight:bold;'>".$key."</td>
				<td style='border:#bbb 1px solid;padding:2px;width:10%;color:$color;font-weight:normal;'>".$qty."</td>
				<td style='border:#bbb 1px solid;padding:2px;width:20%;color:$color;font-weight:normal;'>".$val."</td>
				<td style='border:#bbb 1px solid;padding:2px;width:20%;color:$color;font-weight:normal;'>".$valPercentView."</td>
				</tr>
				\n";
		}

		$output .= "</table>\n";
		$output .= "</fieldset>";

		return $output;
	}

	protected function _compile_queries()
	{
		// Key words we want bolded
		$highlight = array('SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR&nbsp;', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');

		$output  = "\n\n";

		$count = 0;

		if( defined('WPINC') ){
			global $wpdb;
			$queries = $wpdb->queries;
		}
		else {
			$queries = $this->queries;
		}

		$count++;

		$hide_queries = (count($queries) > $this->_query_toggle_count) ? ' display:none' : '';

		$show_hide_js = '(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_queries_db_'.$count.'\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.'profiler_section_hide'.'\'?\''.'profiler_section_show'.'\':\''.'profiler_section_hide'.'\';">'.'profiler_section_hide'.'</span>)';

		if ($hide_queries != ''){
			$show_hide_js = '(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_queries_db_'.$count.'\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.'profiler_section_show'.'\'?\''.'profiler_section_hide'.'\':\''.'profiler_section_show'.'\';">'.'profiler_section_show'.'</span>)';
		}

		$output .= '<fieldset style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.'profiler_queries'.': '.count($queries).'&nbsp;&nbsp;'.$show_hide_js.'</legend>';
		$output .= "\n";
		$output .= "\n\n<table style='width:100%;{$hide_queries}' id='ci_profiler_queries_db_{$count}'>\n";

		if (count($queries) == 0){
			$output .= "<tr><td style='width:100%;color:#0000FF;font-weight:normal;background-color:#eee;padding:5px;'>".'profiler_no_queries'."</td></tr>\n";
		}
		else {
			foreach ($queries as $q){
				list( $sql, $time ) = $q;
				$time = number_format( $time, 4);
				$output .= "<tr><td style='padding:5px; vertical-align: top;width:1%;color:#900;font-weight:normal;background-color:#ddd;'>".$time."&nbsp;&nbsp;</td><td style='padding:5px; color:#000;font-weight:normal;background-color:#ddd;'>".$sql."</td></tr>\n";
			}
		}

		$output .= "</table>\n";
		$output .= "</fieldset>";

		return $output;
	}

	protected function _compile_get()
	{
		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_get" style="border:1px solid #cd6e00;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#cd6e00;">&nbsp;&nbsp;'.'profiler_get_data'.'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (count($_GET) == 0){
			$output .= "<div style='color:#cd6e00;font-weight:normal;padding:4px 0 4px 0'>".'profiler_no_get'."</div>";
		}
		else {
			$output .= "\n\n<table style='width:100%; border:none'>\n";

			foreach ($_GET as $key => $val){
				if ( ! is_numeric($key)){
					$key = "'".$key."'";
				}

				$output .= "<tr><td style='width:50%;color:#000;background-color:#ddd;padding:5px'>&#36;_GET[".$key."]&nbsp;&nbsp; </td><td style='width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;'>";
				if (is_array($val)){
					$output .= "<pre>" . htmlspecialchars(stripslashes(print_r($val, true))) . "</pre>";
				}
				else {
					$output .= htmlspecialchars(stripslashes($val));
				}
				$output .= "</td></tr>\n";
			}

			$output .= "</table>\n";
		}
		$output .= "</fieldset>";

		return $output;
	}

	protected function _compile_post()
	{
		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_post" style="border:1px solid #009900;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#009900;">&nbsp;&nbsp;'.'profiler_post_data'.'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (count($_POST) == 0){
			$output .= "<div style='color:#009900;font-weight:normal;padding:4px 0 4px 0'>".'profiler_no_post'."</div>";
		}
		else {
			$output .= "\n\n<table style='width:100%'>\n";

			foreach ($_POST as $key => $val){
				if ( ! is_numeric($key)){
					$key = "'".$key."'";
				}

				$output .= "<tr><td style='width:50%;padding:5px;color:#000;background-color:#ddd;'>&#36;_POST[".$key."]&nbsp;&nbsp; </td><td style='width:50%;padding:5px;color:#009900;font-weight:normal;background-color:#ddd;'>";
				if (is_array($val)){
					$output .= "<pre>" . htmlspecialchars(stripslashes(print_r($val, TRUE))) . "</pre>";
				}
				else {
					$output .= htmlspecialchars(stripslashes($val));
				}
				$output .= "</td></tr>\n";
			}

			$output .= "</table>\n";
		}
		$output .= "</fieldset>";

		return $output;
	}

	protected function _compile_memory_usage()
	{
		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_memory_usage" style="border:1px solid #5a0099;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#5a0099;">&nbsp;&nbsp;'.'profiler_memory_usage'.'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (function_exists('memory_get_usage') && ($usage = memory_get_usage()) != ''){
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>".number_format($usage).' bytes</div>';
		}
		else {
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>".'profiler_no_memory'."</div>";
		}

		$output .= "</fieldset>";
		return $output;
	}

	protected function _compile_http_headers()
	{
		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_http_headers" style="border:1px solid #000;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#000;">&nbsp;&nbsp;'.'profiler_headers'.'&nbsp;&nbsp;(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_httpheaders_table\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.'profiler_section_show'.'\'?\''.'profiler_section_hide'.'\':\''.'profiler_section_show'.'\';">'.'profiler_section_show'.'</span>)</legend>';
		$output .= "\n";

		$output .= "\n\n<table style='width:100%;display:none' id='ci_profiler_httpheaders_table'>\n";

		foreach (array('HTTP_ACCEPT', 'HTTP_USER_AGENT', 'HTTP_CONNECTION', 'SERVER_PORT', 'SERVER_NAME', 'REMOTE_ADDR', 'SERVER_SOFTWARE', 'HTTP_ACCEPT_LANGUAGE', 'SCRIPT_NAME', 'REQUEST_METHOD',' HTTP_HOST', 'REMOTE_HOST', 'CONTENT_TYPE', 'SERVER_PROTOCOL', 'QUERY_STRING', 'HTTP_ACCEPT_ENCODING', 'HTTP_X_FORWARDED_FOR') as $header){
			$val = (isset($_SERVER[$header])) ? $_SERVER[$header] : '';
			$output .= "<tr><td style='vertical-align: top;width:50%;padding:5px;color:#900;background-color:#ddd;'>".$header."&nbsp;&nbsp;</td><td style='width:50%;padding:5px;color:#000;background-color:#ddd;'>".$val."</td></tr>\n";
		}

		$output .= "</table>\n";
		$output .= "</fieldset>";

		return $output;
	}

	protected function _compile_config()
	{
		return;
	}

	private function _compile_session_data()
	{
		return;
	}

	protected function _compile_events()
	{
		// if (count($this->events) == 0){
			// return;
		// }

		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_events" style="border:1px solid #cd6e00;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#cd6e00;">&nbsp;&nbsp;'.'profiler_events'.'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (count($this->events) == 0){
			$output .= "<div style='color:#cd6e00;font-weight:normal;padding:4px 0 4px 0'>".'profiler_no_events'."</div>";
		}
		else {
			$output .= "\n\n<table style='width:100%; border:none'>\n";

			// foreach ( $this->events as $e ){
				// list( $eventName, $handlerName ) = $e;
				// $output .= "<tr><td style='width:50%;color:#000;background-color:#ddd;padding:5px'>".$eventName."&nbsp;&nbsp; </td><td style='width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;'>";
				// $output .= $handlerName;
				// $output .= "</td></tr>\n";
			// }

			$events = array();
			foreach ( $this->events as $e ){
				list( $eventName, $handlerName ) = $e;
				$key = $eventName . '-' . $handlerName;
				if( ! isset($events[$key]) ){
					$events[$key] = 0;
				}
				$events[$key]++;
			}

			foreach ( $events as $key => $count ){
				list( $eventName, $handlerName ) = explode( '-', $key );
				$viewEventName = $eventName;
				if( $count > 1 ){
					$viewEventName .= ' [' . $count . ']';
				}
				$output .= "<tr><td style='width:50%;color:#000;background-color:#ddd;padding:5px'>".$viewEventName."&nbsp;&nbsp; </td><td style='width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;'>";
				$output .= $handlerName;
				$output .= "</td></tr>\n";
			}

			$output .= "</table>\n";
		}
		$output .= "</fieldset>";

		return $output;
	}

	protected function _renderFactory( $node, $parentNode = '' )
	{
		static $childrenId = 1;

		$out = '';
		$out .= '<div style="">';

		$decimals = 4;

		$nodeStats = $this->factory[$node];

		$keys = array_keys( $this->factory );
		$superNode = $keys[0];
		$superTotalTime = $this->benchmark->getTime( '__factory:' . $superNode );

		$nodeLabel = strlen($parentNode) ? substr( $node, strlen($parentNode) + 1 ) : $node;

		$time = $nodeStats[0];
		$count = $nodeStats[1];

		$totalTime = $this->benchmark->getTime( '__factory:' . $nodeLabel );
		$totalCount = $this->benchmark->getCount( '__factory:' . $nodeLabel );

		$timeView = number_format( $time, $decimals );
		$totalTimeView = number_format( $totalTime, $decimals );

		$valPercent = $totalTime / $superTotalTime;
		$valPercentView = $valPercent * 100;
		$valPercentView = number_format( $valPercentView, 2 );
		$valPercentView .= '%';

		$threshold = 3 / count($this->factory);
		$color = ( $valPercent > $threshold ) ? '#900' : '#999';
		$labelColor = '#61380B';
		if( $this->_factoryIsFunctor($nodeLabel) ){
			$labelColor = '#0b0';
		}
		elseif( $this->_factoryIsMethod($nodeLabel) ){
			$labelColor = '#00b';
		}

		$childrenView = '';
		reset( $this->factory );
		foreach( array_keys($this->factory) as $childNode ){
			if( substr($childNode, 0, strlen($node) + 1) !== $node . '/' ){
				continue;
			}

			$childKey = substr( $childNode, strlen($node) + 1 );
			if( FALSE !== strpos($childKey, '/') ){
				continue;
			}

			$childrenView .= $this->_renderFactory( $childNode, $node );
		}

		if( $childrenView ){
			$nodeLabel = '<span style="text-decoration: underline;">' . $nodeLabel . '</span>';
		}

		$stuffingCount = substr_count( $node, '/' );
		$stuffing = '<div style="display: inline-block; padding: 0 5px; margin: 0 10px; border-right: #bbb 1px solid;">&nbsp;</div>';
		$stuffing = str_repeat( $stuffing, $stuffingCount );

		$nodeView = '';
		$nodeView .= '<table width="100%" style="border-bottom: #bbb 1px solid;">';
		$nodeView .= '<tr>';
		$nodeView .= '<td style="overflow: hidden;width: 70%; color: ' . $labelColor . '; border-right: #bbb 1px solid; padding: 5px;">';
		$nodeView .= $stuffing . $nodeLabel;
		$nodeView .= '</td>';

		$nodeView .= '<td style="width: 4%; color: ' . $color . '; border-right: #bbb 1px solid; padding: 5px; text-align: center;">';
		if( $totalCount > $count ){
			$nodeView .= $count;
		}
		$nodeView .= '</td>';
		$nodeView .= '<td style="width: 7%; color: ' . $color . '; border-right: #bbb 1px solid; padding: 5px; text-align: center;">';
		if( $totalCount > $count ){
			$nodeView .= $timeView;
		}
		$nodeView .= '</td>';

		$nodeView .= '<td style="width: 4%; color: ' . $color . '; border-right: #bbb 1px solid; padding: 5px; text-align: center;">';
		$nodeView .= $totalCount;
		$nodeView .= '</td>';
		$nodeView .= '<td style="width: 7%; color: ' . $color . '; border-right: #bbb 1px solid; padding: 5px; text-align: center;">';
		$nodeView .= $totalTimeView;
		$nodeView .= '</td>';

		$nodeView .= '<td style="width: 8%; color: ' . $color . '; border-right: #bbb 1px solid; padding: 5px; text-align: center;">';
		$nodeView .= $valPercentView;
		$nodeView .= '</td>';

		$nodeView .= '<tr>';
		$nodeView .= '</table>';

		if( $childrenView ){
			$childrenContainerId = 'ci_profiler_factory_children_' . $childrenId++;
			// $showHideJs = '<span style="cursor: pointer; padding: 0 5px;" onclick="var s=document.getElementById(\''.$childrenContainerId.'\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.'[-]'.'\'?\''.'[+]'.'\':\''.'[-]'.'\';">'.'[+]'.'</span> ';

			$nodeView = '<div style="cursor: pointer; text-decoration: underline;" onclick="var s=document.getElementById(\''.$childrenContainerId.'\').style;s.display=s.display==\'none\'?\'\':\'none\';">'. $nodeView . '</div> ';

			// $out .= $showHideJs . $nodeView;
			$out .= $nodeView;
			$out .= '<div style="display: none;" id="' . $childrenContainerId . '">';
			$out .= $childrenView;
			$out .= '</div>';
		}
		else {
			$out .= $nodeView;
		}

		$out .= '</div>';
		return $out;
	}

	protected function _factoryIsClass( $node )
	{
		$dogPos = strpos( $node, '@' );
		$return = ( FALSE === $dogPos ) ? TRUE : FALSE;
		return $return;
	}

	protected function _factoryIsMethod( $node )
	{
		$dogPos = strpos( $node, '@' );
		if( FALSE === $dogPos ){
			$return = FALSE;
		}
		else {
			$return = ( $dogPos === (strlen($node) - 1) ) ? FALSE : TRUE;
		}
		return $return;
	}

	protected function _factoryIsFunctor( $node )
	{
		$dogPos = strpos( $node, '@' );
		if( FALSE === $dogPos ){
			$return = FALSE;
		}
		else {
			$return = ( $dogPos === (strlen($node) - 1) ) ? TRUE : FALSE;
		}
		return $return;
	}

	protected function _compile_factory()
	{
// _print_r( $this->factory );
		$keys = array_keys( $this->factory );
		$superNode = $keys[0];

		$countClasses = $countMethods = $countFunctors = array();
		foreach( $keys as $k ){
			$ka = explode( '/', $k );
			$k = array_pop( $ka );

			if( $this->_factoryIsClass($k) ){
				if( ! isset($countClasses[$k]) ){
					$countClasses[$k] = 0;
				}
				$countClasses[$k]++;
			}
			elseif( $this->_factoryIsMethod($k) ){
				if( ! isset($countMethods[$k]) ){
					$countMethods[$k] = 0;
				}
				$countMethods[$k]++;
			}
			elseif( $this->_factoryIsFunctor($k) ){
				if( ! isset($countFunctors[$k]) ){
					$countFunctors[$k] = 0;
				}
				$countFunctors[$k]++;
			}
		}

		$countClassesView = count( $countClasses );
		$countMethodsView = count( $countMethods ) . '/' . array_sum( $countMethods );
		$countFunctorsView = count( $countFunctors ) . '/' . array_sum( $countFunctors );

		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_events" style="border:1px solid #cd6e00;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#cd6e00;">&nbsp;&nbsp;'.'profiler_factory: ' . 'classes: ' . $countClassesView . ', ' . 'methods: ' . $countMethodsView . ', ' . 'functors: ' . $countFunctorsView .'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		$output .= $this->_renderFactory( $superNode );

		$output .= "</fieldset>";
		return $output;
	}

	public function render( $content = NULL )
	{
		while( $this->factoryStack ){
			$this->markFactoryStackEnd();
		}

		$out = $content . $this->run();
		return $out;
	}

	public function run()
	{
		$this->markEnd( 'total' );

		$outputId = 'codeigniter_profiler';
		$output = "<div id='" . $outputId . "' style='clear:both;background-color:#fff;padding:10px;display:none;'>";
		$fields_displayed = 0;

		foreach ($this->_available_sections as $section){
			if ($this->_compile_{$section} !== FALSE){
				$func = "_compile_{$section}";
				$output .= $this->{$func}();
				$fields_displayed++;
			}
		}

		if ($fields_displayed == 0){
			$output .= '<p style="border:1px solid #5a0099;padding:10px;margin:20px 0;background-color:#eee">'.'profiler_no_profiles'.'</p>';
		}

		$output .= '</div>';


		// $output = '<div style="margin-top: 1em;" onclick="var s=document.getElementById(\''.$outputId.'\').style;s.display=s.display==\'none\'?\'\':\'none\';"><div style="cursor: pointer; text-decoration: underline;">Profiler</div>'. $output . '</div> ';
		$output = '<div style="margin-top: 1em;"><div style="cursor: pointer; text-decoration: underline;" onclick="var s=document.getElementById(\''.$outputId.'\').style;s.display=s.display==\'none\'?\'\':\'none\';">Profiler</div>'. $output . '</div> ';



		return $output;
	}
}

class HC4_Profiler_Benchmark
{
	private $marker = array();
	private $count = array();

	public function getMarkers()
	{
		return array_keys($this->marker);
	}

	public function markStart( $name )
	{
		if( ! isset($this->marker[$name]) ){
			$this->marker[$name] = 0;
			$this->count[$name] = 0;
		}

		$this->marker[$name] -= microtime( TRUE );
		$this->count[$name]++;
	}

	public function markEnd( $name )
	{
		if( isset($this->marker[$name]) ){
			$this->marker[$name] += microtime( TRUE );
		}
	}

	public function getCount( $point )
	{
		$return = isset($this->count[$point]) ? $this->count[$point] : 0;
		return $return;
	}

	public function getTime( $point )
	{
		$return = isset($this->marker[$point]) ? $this->marker[$point] : 0;
		return $return;
	}

	function memory_usage()
	{
		return '{memory_usage}';
	}
}
