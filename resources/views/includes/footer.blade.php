  <div class="footer_top">
        <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <a href="#"><img src="{{ asset('images/logo.png') }}"></a>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--<div class="location_select">
                            <select>
                                <option>Select Location</option>
                                <option>Location 1</option>
                                <option>Location 2</option>
                                <option>Location 3</option>
                                <option>Location 4</option>
                            </select>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col1">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> About</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Team</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Careers</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col2">
                        <h3>Legal</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Terms & Condition</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Refund & Cancellation</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Privacy Policy</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Cookie Policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col2">
                        <h3>CONTACT</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Help & Support</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Partner with us</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Ride With us</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Contact</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col2">
                        <h3>Address</h3>
                        <h4>Head Office:</h4>
                        <p>1422 1st St. Santa Rosa,t CA 94559. USA </p>
                        <div class="phone_email">
                            <p>Call Us:<a href="tel:001123456">(559) 573-6677</a></p>
                            <p>E-mail: <a href="mailto:admin@e-mail.com">admin@e-mail.com</a></p>
                        </div>
                        <div class="social_icons">
                            <ul>
                                <li><a href="https://www.facebook.com/partybuscv" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <!--<li><a href="" target="_blank"><i class="fab fa-twitter"></i></a></li>-->
                                <li><a href="https://www.instagram.com/p/BVWJ2eRjp3I/"><i class="fab fa-instagram"></i></a></li>
                                <!--<li><a href="#"><i class="fab fa-youtube"></i></a></li>-->
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">2020 Copyright  Ruben J. urbano Associates All Right Reserved  </div>
  </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        $('.menu_icon').on('click', function(){
            $('body').addClass('open');
        });
        $('.close_icon').on('click', function(){
            $('body').removeClass('open');
        });
        $('.mob_serach_icon').on('click', function(){
            $('body').toggleClass('searchopen');
        });
    </script>
