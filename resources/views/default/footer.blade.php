         <div class="fixed-footer">
            <footer class="footer">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-6 col-md-3 col-xs-12">
                        <div class="footer_block">
                           <a href="{{route('home')}}" class="f_logo"><img style="height:100px" src="/assets/images/logo.png" class="img-responsive" alt="logo"></a>
                        </div>
                     </div>
                     <div class="col-sm-6 col-md-4 col-xs-12">

                     </div>
                     <div class="col-sm-6 col-md-2 col-xs-12">
                        <div class="footer_block">
                           <h4>Hot Links</h4>
                           <ul class="footer-links">
                              <li> <a href="{{route('home')}}">Home</a> </li>
                              <li> <a href="{{route('home_pages','about-us')}}">About Us</a> </li>
                              <li> <a href="{{route('home_pages','privacy')}}">Privacy</a> </li>
                              <li> <a href="{{route('home_pages','contact-us')}}">Contact Us</a> </li>
                              <li> <a href="{{route('home_pages','terms-of-use')}}">Term & Conditions</a> </li>
                           </ul>
                        </div>
                     </div>
                     <div class="col-sm-6 col-md-3 col-xs-12">
                        <div class="footer_block">
                           <h4>Contact Information</h4>
                           <ul class="personal-info">
                              <li><i class="fa fa-map-marker"></i> 3rd Floor,Link Arcade Model Town, BBL, USA.</li>
                              <li><i class="fa fa-envelope"></i> Support@domain.com</li>
                              <li><i class="fa fa-phone"></i> (0092)+ 124 45 78 678 </li>
                              <li><i class="fa fa-clock-o"></i> Mon - Sun: 8:00 - 16:00</li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </footer>
            <section class="footer-bottom-section">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="footer-bottom">
                           <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                 <p>Copyright ©2017  - All rights Reserved.</p>
                              </div>
                              <div class="col-md-12 col-sm-12 col-xs-12 hidden-xs hidden-sm">
                                 <ul class="footer-menu">
                                    @php
                                       use App\Models\Job, App\Models\Country;

                                       $job = Job::where('is_active','=',1)->get();
                                       $country = [];
                                       foreach($job as $key => $value){
                                         if(!empty($value->country_id)){
                                             $country[$value->country_id] = Country::where('id','=',$value->country_id)->get();   
                                         } 
                                       }
                                    @endphp
                                    @foreach($country as $item)
                                       @foreach($item as $value)
                                          <li> <a href="{{route('search_jobs_by_country',$value['slug'])}}">Jobs in {{$value['name']}}</a> </li>
                                       @endforeach
                                    @endforeach
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>