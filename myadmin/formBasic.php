<?php
include("header.php");
?>
        <div id="page-wrapper">
            <div class="row justify-content-center">
                <!-- Basic Layout Form -->
                <div class="col-md-6 col-lg-5 mx-auto"> <!-- Adjusted column width and centered -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Basic Layout</h3>
                        </div>
                        <div class="panel-body">
                            <form>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control1" id="name" value="John Doe" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input type="text" class="form-control1" id="company" value="ACME Inc." placeholder="Enter company">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control1" id="email" value="john.doe@example.com" placeholder="Enter email">
                                    <small class="help-block">You can use letters, numbers & periods</small>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone No</label>
                                    <input type="text" class="form-control1" id="phone" value="658 799 8941" placeholder="Enter phone">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control1 control2" id="message" placeholder="Enter message">Hi, Do you have a moment to talk Joe?</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <!-- Bootstrap Core JavaScript -->
    <link href="css/custom.css" rel="stylesheet">
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>    
</body>

</html>