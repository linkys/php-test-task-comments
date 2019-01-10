<?php
    require_once 'inc/comment.php';

    $comments = getAllComments();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comments</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">

            <h2 class="mt-2 mb-4">Add a comment</h2>

            <form action="/" method="post" id="form-add-comment">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="message" class="col-sm-2 col-form-label">Message</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="message" rows="3" name="message" placeholder="Message"></textarea>
                        <span class="error-message"></span>
                    </div>
                </div>

                <input type="hidden" name="_token" value="<?php echo csrfToken() ?>">
                <input type="hidden" name="_action" value="add_comment">

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <div class="alert alert-success add-comment-success mt-2" role="alert">
                Your message has been successfully submited!
            </div>

            <div class="alert alert-danger ajax-failed-alert mt-2" role="alert">
                There is some network error :(
            </div>

            <?php if(!empty($comments) && is_array($comments)) : ?>
                <h3 class="mt-5 mb-3">Comments</h3>

                <form action="/" method="get" id="form-search-comment">

                    <input type="hidden" name="_token" value="<?php echo csrfToken() ?>">
                    <input type="hidden" name="_action" value="search_comments">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="s" placeholder="Search by email" aria-label="Search by email" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="reset">Clear</button>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Find</button>
                        </div>
                    </div>
                </form>

                <ul class="list-unstyled comments-holder">
                    <?php foreach($comments as $comment) : ?>
                        <li class="media" data-comment-id="<?php echo $comment->id ?>">
                            <div class="media-body mb-4">
                                <h5 class="mt-0 mb-1"><?php echo $comment->name ?></h5>
                                <h6 class="mt-0 mb-1"><a href="mailto:<?php echo $comment->email ?>"><?php echo $comment->email ?></a></h6>
                                <p class="mt-0 mb-1"><small class="text-muted"><?php echo date("d.m.Y H:i:s", strtotime($comment->created_at)) ?></small></p>
                                <?php echo $comment->message ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </div>
</div>



<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>