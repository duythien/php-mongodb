

<div class="span2"></div>
  <div class="span8">
      <div class="content">
       <h1 class="text-center" ><?php echo $article['title']; ?></h1></br><hr>
        <p><?php echo $article['html']; ?> <p>
      </div>
  </div><!-- span8-->
<div class="span2"></div>

<!-- back/next -->
<div class="row">
  <div class="span2"></div>
  <div class="span8">
        <ul class="pager">
        </ul>
  </div>
</div>
<div class="span2"></div>
<div class="row"><!-- comment -->
      <div class="span8">
           <?php if (!empty($article['comments'])): ?>
                <h3>Comments</h3>
                <?php foreach($article['comments'] as $comment):
                    echo $comment['name'].'<strong> says... </strong>';?>
                    <p><?php echo $comment['comment']; ?></p>
                    <span><?php echo date('g:i a, F j', $comment['posted_at']->sec); ?></span><br/>
                <?php endforeach;
            endif;?>

          <h3>Post your comment</h3>
          <form method="post" action="comment.php">
              <div><label for="fName">Name</label>
                  <input type="text" name="fName" id="fName" required="required" />
              </div>
              <div><label for="fEmail">Email address</label>
                <input type="email" name="fEmail" id="fEmail" required="required" placeholder="name@example.com" />
              </div>

              <div><label for="fQuestion">Question/Comments</label>
                <textarea name="fComment" cols="40" rows="8" class="span8 wmd-input"></textarea>
              </div>
              <input type="hidden" name="article_id" value="<?php echo $article['_id']; ?>"/>
              <div class="submit"><input type="submit" name="contact-submit" id="contact-submit" value="Submit" /></div>
          </form>
      </div>

</div>