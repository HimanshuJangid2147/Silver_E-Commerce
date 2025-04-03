@include('layouts.header')
@include('layouts.mobilemenu')
<!-- breadcumb area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">Testimonial</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Here!- </li>
                        <li><a href="#">Home</a></li>
                        <li> -<span class="current">Testimonial</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End breadcumb area -->
<!-- testimonial area -->
<div class="jl_test_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tts text-center">
                    <div class="ttin">
                        <h2 class="txbdstitle sttwo hlight">Customer Review</h2>
                    </div>
                </div>
                <div class="witr_carousel_main row test_active">
                    <?php if ($customerreviews->isEmpty()): ?>
                    <div class="col-md-12 text-center">
                        <p>No customer reviews available yet.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($customerreviews->take(3) as $index => $review): ?>
                    <!-- single test -->
                    <div class="col-md-12 txbdmb30">
                        <div class="tsitem text-center alltesicl">
                            <div class="tsimg tsst4">
                                <h2 class="tstitle">
                                    <?php echo htmlspecialchars($review->customer_name); ?>
                                </h2>
                            </div>
                            <div class="tscon">
                                <p><?php echo htmlspecialchars($review->customer_review); ?></p>
                                <div class="tsreview tsdflex d-flex align-items-center justify-content-center">
                                    <div class="tsrevstar">
                                        <?php
                                            $rating = $review->customer_ratings;
                                            for ($i = 1; $i <= $rating; $i++) {
                                        ?>
                                            <i class="ti-star txbdbcolor"></i>
                                        <?php
                                            }
                                            for ($i = 1; $i <= (5 - $rating); $i++) {
                                        ?>
                                            <i class="ti-star txbdbcolor-inactive"></i>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
