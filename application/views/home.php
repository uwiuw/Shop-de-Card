<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
    <head>  
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
        <title><?php echo $title; ?></title>  
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />  

    </head>  

    <body>  
        <div id="main">  

            <div class="container">  

                <div id="header">  
                    <div id="top_nav">
                        <div class="top_nav_left"></div>
                        <div class="top_nav_center">
                            <div class="nav_top">Welcome User &nbsp; &nbsp; <span class="my_account">My Account &nbsp; |  &nbsp; Logout&nbsp;&nbsp;&nbsp;</span></div>
                        </div>
                        <div class="top_nav_right"></div>
                    </div>

                    <!--logo-->
                    <div id="logo">
                        <div class="top_left"></div>
                        <div class="top_center">
                            <div class="cart">
                                <div class="shop_cart">your cart <div class="total_price">$ XXX.XX</div></div>
                            </div> 
                            <div class="phone"></div>
                            <a href="<?= site_url() ?>"><img src="<?= img_dir() ?>cherub_logo.png" width="675" height="149" /></a>
                        </div>
                        <div class="top_right"></div>
                    </div>

                    <!--search bar-->
                    <div id="search_bar">
                        <div class="search_bar_left"></div>
                        <div class="search_bar_center">
                            <div class="search">Search &nbsp;&nbsp;&nbsp;<input type="text" name="search" id="search"/></div>
                        </div>
                        <div class="search_bar_right"></div>
                    </div>

                </div>  
                <!--Side Menu-->

                <!--main product-->
                <div class="main_product">
                    <div class="leftbar">
                        <div class="categories_left"></div>
                        <div class="categories_center">
                            <div class="categories">
                                <div class="product_title"><div class="prod_cat">Product Categories</div></div>
                                <ul class="cat">
                                    <li>Categories 1</li>
                                    <li>Categories 2</li>
                                    <li>Categories 3</li>
                                    <li>Categories 4</li>
                                    <li>Categories 5</li>
                                    <li>Categories 6</li>
                                    <li>Categories 7</li>
                                    <li>Categories 8</li>
                                    <li>Categories 9</li>
                                    <li>Categories 10</li>
                                    <li>Categories 11</li>
                                    <li>Categories 12</li>
                                </ul>
                                <div class="testi">
                                    <p class="client">Client Testimonial</p>
                                    <p class="testi_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Ut sit amet augue enim, id interdum arcu. Suspendisse vehicula, 
                                        nisl sit amet ultricies aliquam.</p>

                                    <p  class="testi_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Ut sit amet augue enim, id interdum arcu. Suspendisse vehicula, 
                                        nisl sit amet ultricies aliquam.</p>
                                    <div class="testi_bottom"></div>
                                </div>
                                <!--                                    <div class="testi_right"></div>-->

                            </div>
                        </div>
                        <div class="categories_right"></div>
                    </div>

                    <!-- Product Main Highlight -->
                    <div class="product_left"></div>
                    <div class="product_center">
                        <div class="prod_highlight">
                            <p class="p_highlight">Lorem ipsum dolor sit amet</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Ut sit amet augue enim, id interdum arcu. Suspendisse vehicula, 
                                nisl sit amet ultricies aliquam.</p>

                            <a href="#" class="check_product_button">Check Product</a>
                        </div>
                    </div>
                    <div class="product_right"></div>

                    <!--items-->
                    <div class="items">

                        <div class="items_left"></div>
                        <div class="items_center">

                            <div class="item_in"><h3>Item you might be interest in</h3></div>
                            <div class="products">
                                <div class="product_list">
                                    <a href="klematis4_big.htm">
                                        <img src="<?= img_dir() ?>spray.png" alt="Klematis" width="118" height="150" />
                                    </a>
                                    <div class="product_desc">Add a description of the image here</div>
                                    <div class="button">$ 999 </div>
                                </div>
                                <div class="product_list">
                                    <a href="klematis4_big.htm">
                                        <img src="<?= img_dir() ?>spray.png" alt="Klematis" width="118" height="150" />
                                    </a>
                                    <div class="product_desc">Add a description of the image here</div>
                                    <div class="button">$ 999 </div>
                                </div>
                                <div class="product_list">
                                    <a href="klematis4_big.htm">
                                        <img src="<?= img_dir() ?>spray.png" alt="Klematis" width="118" height="150" />
                                    </a>
                                    <div class="product_desc">Add a description of the image here</div>
                                    <div class="button">$ 999 </div>
                                </div>
                                <div class="product_list">
                                    <a href="klematis4_big.htm">
                                        <img src="<?= img_dir() ?>spray.png" alt="Klematis" width="118" height="150" />
                                    </a>
                                    <div class="product_desc">Add a description of the image here</div>
                                    <div class="button">$ 999 </div>
                                </div>
                            </div>

                        </div>
                        <div class="items_right"></div>
                    </div>

                    <!--bottom-->
                    <div id="bottom">
                        <div class="bottom_left"></div>
                        <div class="bottom_center">
                            <!--Sign UP-->
                            <div id="sign_up">
                                <input type="text" class="sign_up" name="email" value="Email Address"/>
                                <input type="text" class="sign_up" name="email" value="First Name" />
                                <input type="text" class="sign_up" name="email" value="Zip Code" />
                            </div>
                            <!--Links-->
                            <div id="links">
                                <ul>
                                    <li>Home</li>
                                    <li>Shipping</li>
                                    <li>Return Policy</li>
                                    <li>Terms & Condition</li>
                                </ul>
                            </div>
                            <!--External Links-->
                            <div id="ext_links">
                                <ul>
                                    <li>Cherub blog</li>
                                    <li>Youtube</li>
                                    <li>Facebook</li>
                                    <li>Twitter</li>
                                </ul>
                            </div>
                        </div>
                        <div class="bottom_right"></div>
                    </div>

                </div>

            </div>  

        </div>  

        <div id="footer">  
            <div class="container">
                <div class="footer_left"></div>
                <div class="footer_center">Copyright</div>
                <div class="footer_right"></div>
            </div>
        </div>  
    </body>  
</html>  