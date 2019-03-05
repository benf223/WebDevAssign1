<!DOCTYPE html>
<html>
<head>
    <title>Post</title>
    <meta charset="utf-8">
    <!--Bootstrap requirements-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Status Posting System</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!--Form data being collected for the processing page-->
                <form action="postatusprocess.php" method="post">
                    <div class="form-group">
                        <label>Status Code (required): </label>
                        <!--Requires the status code to be in the correct form client side-->
                        <input name="status_code" type="text" placeholder="S0000" pattern="([S])+[0-9]{4}" title="Status Code should start with an S and have 4 digits." required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status (required): </label>
                        <input name="status" type="text" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Share: </label>
                        <div class="form-check">
                            <input type="radio" name="share" value="Public" checked class="form-check-input">
                            <label class="form-check-label">Public</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="share" value="Friends" class="form-check-input">
                            <label class="form-check-label">Friends</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="share" value="Me" class="form-check-input">
                            <label class="form-check-label">Only Me</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Permission Type: </label>
                        <div class="form-check">
                            <input type="checkbox" name="perm_like" class="form-check-input">
                            <label class="form-check-label">Allow Like</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="perm_comment" class="form-check-input">
                            <label class="form-check-label">Allow Comment</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="perm_share" class="form-check-input">
                            <label class="form-check-label">Allow Share</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date: </label>
                        <!--Provides a date selector for the user and provides the current date of the php server-->
                        <input name="date" type="date" value="<?php echo date("Y-m-d");?>" required class="form-control">
                    </div>
                    <input type="submit" name="submit" value="Submit" class="btn btn-light">
                    <input type="reset" class="btn btn-light">
                    <br>
                </form>
            </div>
        </div>
        <br>
        <a href="/assign1" class="btn btn-light">Return to Home Page</a>
    </div>
</body>
</html>
