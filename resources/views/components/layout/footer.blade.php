<footer class="footer-area">
    <div class="container">
        <div class="footer-top">
            <div class="footer-social-link">
                <ul class="list-unstyled">
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="200"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300"><i class="fab fa-pinterest-p"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="400"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="500"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="600"><i class="fab fa-vimeo-v"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="700"><i class="fab fa-dribbble"></i></a></li>
                    <li><a href="#" data-sal="slide-up" data-sal-duration="500" data-sal-delay="800"><i class="fab fa-behance"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-main">
            <div class="row">
                <div class="col-xl-6 col-lg-5" data-sal="slide-right" data-sal-duration="800" data-sal-delay="100">
                    <div class="footer-widget border-end">
                        <div class="footer-newsletter">
                            <h2 class="title">Get in touch!</h2>
                            <p>Fusce varius, dolor tempor interdum tristique, dui urna bib
                                endum magna, ut ullamcorper purus</p>
                            <form>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Email address">
                                    <button class="subscribe-btn" type="submit">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7" data-sal="slide-left" data-sal-duration="800" data-sal-delay="100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="footer-widget">
                                <h6 class="widget-title">Services</h6>
                                <div class="footer-menu-link">
                                    <ul class="list-unstyled">
                                        <li><a href="#">Logo &amp; Branding</a></li>
                                        <li><a href="#">Website Development</a></li>
                                        <li><a href="#">Mobile App Development</a></li>
                                        <li><a href="#">Search Engine Optimization</a></li>
                                        <li><a href="#">Pay-Per-Click</a></li>
                                        <li><a href="#">Social Media Marketing</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="footer-widget">
                                <h6 class="widget-title">Resourses</h6>
                                <div class="footer-menu-link">
                                    <ul class="list-unstyled">
                                        <li><a href="{{ url('/blog') }}">Blog</a></li>
                                        <li><a href="{{ url('/case-study') }}">Case Studies</a></li>
                                        <li><a href="{{ url('/projects') }}">Portfolio</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="footer-widget">
                                <h6 class="widget-title">Support</h6>
                                <div class="footer-menu-link">
                                    <ul class="list-unstyled">
                                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                                        <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                                        <li><a href="{{ url('/terms') }}">Terms of Use</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-copyright">
                        <div class="live-status">
                            <span class="live-dot" aria-hidden="true"></span>
                            <span>Live Status</span>
                        </div>
                        <span class="copyright-text">&copy; {{ date('Y') }}. All rights reserved by <a href="https://example.com">Chalang</a>.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-bottom-link">
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ url('/terms') }}">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
