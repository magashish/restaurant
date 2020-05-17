  <div class="footer_top">
        <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <a href="#"><img src="{{ asset('images/logo.png') }}"></a>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="location_select">
                            <select>
                                <option>Select Location</option>
                                <option>Location 1</option>
                                <option>Location 2</option>
                                <option>Location 3</option>
                                <option>Location 4</option>
                            </select>
                        </div>
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
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Blog</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Careers</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Report Fraud</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col2">
                        <h3>RESTAURANTS</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Add Restaurants</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Claim your Listing</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Business App</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Restaurant Widgets</a></li>
                            <li><a href="#"><i class="fas fa-angle-double-right"></i> Products for Businesses</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col2">
                        <h3>Working Hours</h3>
                        <ul>
                            <li>Monday <span>1pm - 10pm</span></li>
                            <li>Tuesday <span>1pm - 10pm</span></li>
                            <li>Wednesday <span>1pm - 10pm</span></li>
                            <li>Thursday <span>1pm - 10pm</span></li>
                            <li>Friday <span>1pm - 10pm</span></li>
                            <li class="day_close">Saturday <span>Closed</span></li>
                            <li>Sunday <span>1pm - 10pm</span></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12 foot_col2">
                        <h3>Contact Us</h3>
                        <h4>Head Office:</h4>
                        <p>1422 1st St. Santa Rosa,t CA 94559. USA </p>
                        <div class="phone_email">
                            <p>Call Us:<a href="tel:001123456">(001) 123-4567</a></p>
                            <p>E-mail: <a href="mailto:admin@e-mail.com">admin@e-mail.com</a></p>
                        </div>
                        <div class="social_icons">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
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