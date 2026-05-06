<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>
<div>
{{--
<div class="tab-pane chart-sidebar fade show active" role="tabpanel">
    <div class="card">
        <div class="card-header align-items-start">
            <div>
                <h6>Daily Sales</h6>
                <p>Check out each colum for more details</p>
            </div>
            <span class="btn btn-primary light sharp ms-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"/><rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"/><path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/><rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/></g></svg>
            </span>
        </div>
        <div class="card-body">
            <canvas id="daily-sales-chart" height="85" style="height:85px;"></canvas>
        </div>
    </div>
    <div class="card bg-warning-light">
        <div class="card-header align-items-start mb-3">
            <div>
                <h6>Profit Share</h6>
                <p>Check out each colum for more details</p>
            </div>
            <span class="btn btn-warning light sharp ms-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M4.00246329,12.2004927 L13,14 L13,4.06189375 C16.9463116,4.55399184 20,7.92038235 20,12 C20,16.418278 16.418278,20 12,20 C7.64874861,20 4.10886412,16.5261253 4.00246329,12.2004927 Z" fill="#000000" opacity="0.3"/><path d="M3.0603968,10.0120794 C3.54712466,6.05992157 6.91622084,3 11,3 L11,11.6 L3.0603968,10.0120794 Z" fill="#000000"/></g></svg>
            </span>
        </div>
        <div class="card-body">
            <div class="chart-point">
                <div class="check-point-area">
                    <canvas id="ShareProfit"></canvas>
                </div>
                <ul class="chart-point-list">
                    <li><i class="fa fa-circle text-primary me-1"></i> 40% Tickets</li>
                    <li><i class="fa fa-circle text-success me-1"></i> 35% Events</li>
                    <li><i class="fa fa-circle text-warning me-1"></i> 25% Other</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card bg-info-light">
        <div class="card-header align-items-start mb-3">
            <div>
                <h6>Visitors By Browser</h6>
                <p>Check out each colum for more details</p>
            </div>
            <span class="btn btn-info light sharp ms-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M3,4 L20,4 C20.5522847,4 21,4.44771525 21,5 L21,7 C21,7.55228475 20.5522847,8 20,8 L3,8 C2.44771525,8 2,7.55228475 2,7 L2,5 C2,4.44771525 2.44771525,4 3,4 Z M10,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,19 C21,19.5522847 20.5522847,20 20,20 L10,20 C9.44771525,20 9,19.5522847 9,19 L9,11 C9,10.4477153 9.44771525,10 10,10 Z" fill="#000000"/><rect fill="#000000" opacity="0.3" x="2" y="10" width="5" height="10" rx="1"/></g></svg>
            </span>
        </div>
        <div class="card-body">
            <p class="mb-2 d-flex"><img width="22" height="22" src="images/browser/icon1.png" class="me-2" alt="">Photoshop
                <span class="pull-right text-warning ms-auto">85%</span>
            </p>
            <div class="progress mb-3" style="height:4px">
                <div class="progress-bar bg-warning progress-animated" style="width:85%; height:4px;" role="progressbar">
                    <span class="sr-only">60% Complete</span>
                </div>
            </div>
            <p class="mb-2 d-flex"><img width="22" height="22" src="images/browser/icon2.png" class="me-2" alt="">Code editor
                <span class="pull-right text-success ms-auto">90%</span>
            </p>
            <div class="progress mb-3" style="height:4px">
                <div class="progress-bar bg-success progress-animated" style="width:90%; height:4px;" role="progressbar">
                    <span class="sr-only">60% Complete</span>
                </div>
            </div>
            <p class="mb-2 d-flex"><img width="22" height="22" src="images/browser/icon1.png" class="me-2" alt="">Illustrator
                <span class="pull-right text-danger ms-auto">65%</span>
            </p>
            <div class="progress" style="height:4px">
                <div class="progress-bar bg-danger progress-animated" style="width:65%; height:4px;" role="progressbar">
                    <span class="sr-only">60% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
</div>