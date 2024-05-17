<?php
session_start();
include_once "php/config.php";

// Check if user is logged in
if(!isset($_SESSION['unique_id'])){
  header("location: login.php");
  exit;
}

// Fetch group chat details
if (isset($_GET['group_id'])) {
    $group_id = $_GET['group_id'];
    // Fetch group chat name
    $sql_group = "SELECT * FROM groups WHERE group_id = $group_id";
    $result_group = mysqli_query($conn, $sql_group);
    if ($result_group && mysqli_num_rows($result_group) > 0) {
        $group = mysqli_fetch_assoc($result_group);
        $group_name = $group['group_name'];
    } else {
        // Handle error
        echo "Group not found";
        exit;
    }

    // Fetch group members
    $sql_members = "SELECT users.* FROM users 
                    INNER JOIN group_members ON users.unique_id = group_members.user_id
                    WHERE group_members.group_id = $group_id";
    $result_members = mysqli_query($conn, $sql_members);
    $members = [];
    if ($result_members && mysqli_num_rows($result_members) > 0) {
        while ($row = mysqli_fetch_assoc($result_members)) {
            $members[] = $row;
        }
    } else {
        // Handle no members found
        echo "No members found";
    }
} else {
    // Handle no group_id provided
    echo "Group ID not provided";
    exit;
}
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>