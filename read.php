<?php
    include ('db_connect.php');
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>게시판</title>
</head>
<body>
    <?php
    $board_id = $_GET['board_id'];
        $bno = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/
        $hit = mysqli_fetch_array(mq("select * from ".$board_id." where idx ='".$bno."'"));
        $hit = $hit['hit'] + 1;
        $fet = mq("update ".$board_id." set hit = '".$hit."' where idx = '".$bno."'");
        $sql = mq("select * from ".$board_id." where idx='".$bno."'"); /* 받아온 idx값을 선택 */
        $board = $sql->fetch_array();
    ?>
<!-- 글 불러오기 -->
  <div id="board_read">
       <h2><?php echo $board['title']; ?></h2>
           <div id="user_info" align=right>
                  <?php echo $board['name']; ?> <?php echo $board['date']; ?> 조회:<?php echo $board['hit']; ?>
                    <div id="bo_line"></div>
            </div>
            <div>
                파일 : <a href="uploads/<?php echo $board['file'];?>" download><?php echo $board['file']; ?></a>
            </div>
            <div id="bo_content">
                <?php echo nl2br("$board[content]"); ?>
            </div>
 
    <!-- 목록, 수정, 삭제 -->
 
       <div id="bo_ser">
             <ul>
                    <li><a href="board.php?board_id=<?echo $board_id;?>">[목록으로]</a></li>
              <?if ($board['name']==$_SESSION['userid']){?>
                    <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
                    <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
              <?}?>
            </ul>
      </div>
 
  </div>
  <!--- 댓글 불러오기 -->
<div class="reply_view">
    <h3>댓글목록</h3>
        <?php
            $sql3 = mq("select * from ".$board_id."_reply where con_num='".$bno."' order by idx desc");
            while($reply = $sql3->fetch_array()){
        ?>
        <div class="dap_lo">
            <div><b><?php echo $reply['name'];?></b></div>
            <div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
            <div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
 
        </div>
    <?php } ?>
 
    <!--- 댓글 입력 폼 -->
    <div class="dap_ins">
        <form action="reply_ok.php?board_id=<?echo $board_id;?>&idx=<?php echo $bno; ?>" method="post">
            <input type="hidden" name="dat_user" id="dat_user" class="dat_user" size="15" placeholder="아이디" value=<?$_SESSION['userid']?>>
            <div style="margin-top:10px; ">
                <textarea name="content" class="reply_content" id="re_content" ></textarea>
                <button id="rep_bt" class="re_bt">댓글</button>
            </div>
        </form>
    </div>
</div><!--- 댓글 불러오기 끝 -->
<div id="foot_box"></div>
</div>
</body>
</html>
