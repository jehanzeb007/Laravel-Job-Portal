<div class="banner">
                <h4>Subject:</h4> <p>LETTER OF AGREEMENT TO ACCOMPLISH <strong>{{$jobData->job_name}}</strong>. </p>
            </div>
            <div class="block-sec">
                <p>Dear, Mr.  <strong>{{$awardedUserData->first_name.' '.$awardedUserData->last_name}}.</strong></p>
            </div>
            <div class="block-sec">
                <p>This agreement is made between <strong>{{$jobData->first_name.' '.$jobData->last_name}}</strong> and <strong>{{$awardedUserData->first_name.' '.$awardedUserData->last_name}}.</strong> on the date of {{date('d, m, Y',strtotime($jobData->contracts_date))}} has assigns {{$awardedUserData->first_name.' '.$awardedUserData->last_name}} to " {{$jobData->contract_description}} ".for which necessary agreement has to make by the two parties</p>
            </div>
            <div class="middle-sec">
                <p>In terms of providing (Missions, services, jobs) that both parties agreed on, the price for </p>
                <ul class="list">
                	@php
                    	$job_attributes = unserialize($jobData->job_attributes);
                        if(isset($job_attributes['Price Range']) && $job_attributes['Price Range'] != ''){
                        	$price = $job_attributes['Price Range'];
                        }else{
                        	$price = '0';
                        }
                    @endphp
                    <li>Price $ {{$price}}</li>
                </ul>
                <p>The payment via <strong>{{$jobData->payment_via}}</strong> </p>
            </div>
            <div class="middle-sec">
                <h4>Term of agreement</h4>
                <p>The Company aims to organize and bring the job seekers and providers closer through the Internet. The TOIL Company does not hold any minimum legal liability or responsibility in this contract or its establishment or any right or legal claims of the two parties as it has been established based on the agreements of both parties.</p>
                <h4>Yours Sincerely !</h4>
                <p>{{$jobData->first_name.' '.$jobData->last_name}}</p>
            </div>
            <div class="middle-sec">
                <h4>TOIL COMPANY</h4>
                <p>Make Life Easy with Simple job Communications</p>
            </div>