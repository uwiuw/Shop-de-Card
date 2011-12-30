<?php
/*By Haidar Mar'ie 
 *Email = coder5@ymail.com 
category */
?>
<div class="leftbar">
                        <div class="categories_left"></div>
                        <div class="categories_center">
                            <div class="categories">
                                <div class="product_title"><div class="prod_cat">Product Categories</div></div>
                                <ul class="cat">
                                    <?php
                                    foreach($this->categories as $cat){
                                        echo "<li><a href='".site_url()."/webshop/cat/".$cat['category_id']."'>".$cat['name']."</a></li>";
                                    }
                                    ?>
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