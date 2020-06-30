

<?php include_once "header.inc.php" ?>

<div class="container-fluid">
    <div class="row">

<?php include_once "sidebar.inc.php" ?>

        <div id="admin-main-control" class="col-md-10 p-x-3 p-y-1">
            <div class="content-title m-x-auto">
                <i class="fa fa-dashboard"></i> Coaches
            </div>
            <div class="row justify-content-center">
                <div class="col-2">
                    <p>Dota 2</p>
                    <a href="coaches_dota.php"><img src="img/dota-logo.png" width="100px" height="100px" alt="" data-pagespeed-url-hash="2788970807" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a>
                </div>
                <div class="col-2">
                    <p>League of Legends</p>
                    <a href="coaches_lol.php"><img src="img/lol-logo.png" width="100px" height="100px" alt="" data-pagespeed-url-hash="3205984022" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a>
                </div>
                <div class="col-2">
                    <p>Other platforms</p>
                    <a href="coaches_others.php"><img src="img/logo.png" width="100px" height="100px" alt="" data-pagespeed-url-hash="3643868122" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a>
                </div>
            </div>
            <hr>
            <p>🔥Popular coaches</p>
            <div class="row justify-content-start">
                <div class="col-4">
                    <p>Arsultan Nursapa</p>
                    <p>Field: Dota 2</p>
                    <img src="img/arsultan.jpg" width="100px" height="100px" alt="" data-pagespeed-url-hash="2307178959" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></div>
                <div class="col-2">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="9ELHYU372DMHY">
                        <table>
                            <tr><td><input type="hidden" name="on0" value="price options">price options</td></tr><tr><td><select name="os0">
                                        <option value="1 hour">1 hour $0.85 USD</option>
                                        <option value="2 hours">2 hours $0.16 USD</option>
                                        <option value="4 hours">4 hours $0.27 USD</option>
                                    </select> </td></tr>
                        </table>
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>

                </div>
                <div class="col-4">
                    <p>Faker</p>
                    <p>Field: Legal of Legends</p>
                    <img src="data:image/webp;base64,UklGRhgFAABXRUJQVlA4IAwFAACwGgCdASpkAGQAPpE+m0glo6KhrRWbCLASCWcA1SXMBgGSAWUO1M/I+F/X6k/k2+fTtJl38KNPT8089/owaR/pk3qzPvrT6l3660EhthNJAlVHqz/28+8mQWgeJSdV1W5OqhpKJ7jf8H01jwx511UaFs/INy0PsleCqJjMSzo44gb9a7AkIkncWYpqUAeWWeN2HPTs5D+rTqS7RtxILFHtRuWaW500Cjcvn2ZI5z5Zj4nn/oDL4pfuyd7FeJbLaWKpC1GSpu/HRJxnp6QII4FDGGA63cITH2iyFuZzxwAA/vshxPRHXBRni+YDbdI+lE8AxFl22Eg8N536VA4rZRlCfn0+LBLrk527aFHtgujtOR0618uBBEkBCnvtesFq3BP8xT1MhPN0oFlpQpp1pnZRt8LDjhpeILaU9W7LFsEW/i7G0iZwnjyKu+/CyMvJMJAnG7PPCsIGDCJ95islc96zymyud7vtAAoNVECnKLr4agOI8Etb0JoVhLQuBp8NTqUQ6Q25c3xP0s4mX+cHmrYg9OvGVTvQOkxD32xEYbT6uav2xAfzKriI+SG5p9QppfKoS9WCFpIK2hBsR9hWXOLtNvmu9QeK+IEz6pQTCT/hr9vgJY1v9Pgc5LrSGRdDTHg86XmEimLb4FGvRCi3bn3oz+R4VarpEJ+oQJc4Fb6lzGW00201gv6A1rqHsoClCwffPEkM5U54/ruhp0vTIUpwSAf9wBX8RU4l3nW/o0dAIQk6g8Wqc+k4qLVcapzg1Eu0Kp9p6RVQc+JVhqjU3fZQItzhxgbpqxCOpzTGG+nP8vr3k4wJmuR/S/KA6U0nJcuAuYBGETkL2xpxgfqrZM/+CP4ZDhR10cQvHJH6AYc9SDarOZeBzi4AqGbs87+i1Ff4sYuB3yt/p3zoTBYqJGhn/NG0NZcsKa+nZcCm4K2mGq4ZpA1V78LJXbaWqWSW+fh09+oWKKapgn1ZZtsB4XS0FXOZ9MmYn46FKC7g2b/dMzx//bHTRqkwJuGex1tP7vWDvdntTrWmx3yhRVb2qz0yUrfV+AqUCsDyRK7eI6+/kch/XC4f5apFG+sVGxZI3InKdlEwp7Ef+zJE7pWjmcmJntXHeYKpyJPxuWu+YIswR2qhwsTr8aYh/Xfa0LvuT3VzrMmGqgbZ0AdEdaUsA0yz0q+qXRdZTo8wZgXJg12kvXnHhDv8ZyaufXTmrh5hLT/jMLhnTCkxV3Yox2LJSWEVxqLzpwzAEFf+fD9mV+nnd5bSmyIO9x481DI92t5fhfZpRLSdcs2FBqWfL8l7uHhsaihh3AHE5/IA2A5zEhIboL0Rkj1Swnt2bdQvI4lTm6+q7VVRjUwoYwh34bgDmW0CJN2xrEtPpLV28LdftEx/kx3JZIlpeDuVw9ISCzJa/QORPdtmRmExQCemdRIrd9VUIWn/F69L07885VK5Hb891jMad7OcSu4SpP7oPZ3WlBUZtjIe2hmjxW5GjO53f982HcPfBkhYnZkrKzXOVpcxFEs10CaBq3P0viZP/PICDt46V2bS7rvJeCC9EJiCp/QhvsC3IBcFIctMfiV/9ehsYsptCGuWCTm2laSQO3+zPA/+z/A5VX7ijbh2UE+IL7ylienOJJVSY7DHGa2sBAL9fqIIyCHZi6Q61ocP4DIK+SEhiMRKFOEN6mNRifu1ZNIBcKE2FbX3DVDUgtvx+2EY4Q3EYaM6Y+ZyuNAAAA==" alt="" data-pagespeed-url-hash="2793912192" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></div>
                <div class="col-2">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="TSVLUD98KJUSL">
                        <table>
                            <tr><td><input type="hidden" name="on0" value="price options">price options</td></tr><tr><td><select name="os0">
                                        <option value="1 hour">1 hour $0.55 USD</option>
                                        <option value="2 hours">2 hours $0.10 USD</option>
                                        <option value="4 hours">4 hours $0.13 USD</option>
                                    </select> </td></tr>
                        </table>
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>

                </div>
            </div>


            <hr>

        </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<?php include_once "footer.inc.php" ?>


