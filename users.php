<?php 
session_start();
include_once "php/config.php";
if(!isset($_SESSION['unique_id'])){
  header("location: login.php");
  exit; // Ensure script stops if user is not logged in
}
?>
<?php include_once "header.php"; ?>
<body>
  <style>
    /* style.css */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
    }

    .wrapper {
      max-width: 1200px;
      width: 100%;
      margin: 0 auto;
      padding: 20px;
    }

    .users {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .users header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .users header .content {
      display: flex;
      align-items: center;
    }

    .users header img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .users header .details {
      display: flex;
      flex-direction: column;
    }

    .users header .details span {
      font-weight: bold;
      font-size: 16px;
    }

    .users header .details p {
      font-size: 14px;
      color: #666;
    }

    .logout {
      padding: 8px 16px;
      background-color: #f44336;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
    }

    .search {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .search .text {
      margin-right: 10px;
    }

    .search input[type="text"] {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      flex-grow: 1;
    }

    .search button {
      padding: 8px 12px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 10px;
    }

    .users-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .user {
      display: flex;
      align-items: center;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      padding: 10px;
      cursor: pointer;
    }

    .user img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .user .details {
      flex-grow: 1;
    }

    .user .details span {
      font-weight: bold;
      font-size: 14px;
    }

    .user .details p {
      font-size: 12px;
      color: #666;
    }

    .create-group-chat-btn {
      padding: 12px 24px;
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 20px;
    }

    .add-user-btn {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 10px;
    }

    .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
  }

  .modal-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    padding: 20px;
    width: 80%;
    max-width: 600px;
    margin: 50px auto;
    position: relative;
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .modal-close {
    cursor: pointer;
    font-size: 24px;
    color: #666;
  }

  .modal-body {
    max-height: 400px;
    overflow-y: auto;
  }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
  }

  .users-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
  }

  .user {
    background-color: #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    position: relative;
  }

  .user:hover {
    background-color: #e0e0e0;
  }

  .user .details {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
  }

  .user img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .user .details span {
    font-weight: bold;
    font-size: 14px;
    color: #333;
  }

  .user .details p {
    font-size: 12px;
    color: #666;
    margin-top: 2px;
  }

  .add-user-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    position: absolute;
    top: 10px;
    right: 10px;
  }

  .add-user-btn:hover {
    background-color: #0056b3;
  }

  /* Selected Users Styles */
  .selected-users {
    margin-top: 20px;
  }

  .selected-users .user {
    display: flex;
    align-items: center;
    background-color: #d4edda;
    border-radius: 8px;
    padding: 8px;
    margin-bottom: 8px;
  }

  .selected-users .user img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 10px;
  }
  .selected-users .user .details {
    flex-grow: 1;
  }

  .selected-users .user .details span {
    font-weight: bold;
    font-size: 14px;
    color: #155724;
  }

  .selected-users .user .details p {
    font-size: 12px;
    color: #155724;
    margin-top: 2px;
  }

  .remove-user-btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
  }
  </style>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
          $row = []; // Initialize $row as an empty array
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <img src="php/images/<?php echo isset($row['img']) ? $row['img'] : ''; ?>" alt="">
          <div class="details">
            <span><?php echo isset($row['fname']) && isset($row['lname']) ? $row['fname'] . " " . $row['lname'] : ''; ?></span>
            <p><?php echo isset($row['status']) ? $row['status'] : ''; ?></p>
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo isset($row['unique_id']) ? $row['unique_id'] : ''; ?>" class="logout">Logout</a>
      </header>
      <div class="search">
        <span class="text">Select users to create a group chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
        <?php 
        $sql_users = mysqli_query($conn, "SELECT * FROM users WHERE unique_id != {$_SESSION['unique_id']}");
        if(mysqli_num_rows($sql_users) > 0){
          while($row_users = mysqli_fetch_assoc($sql_users)){
        ?>
        <div class="user" data-user-id="<?php echo $row_users['unique_id']; ?>">
          <img src="php/images/<?php echo $row_users['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row_users['fname'] . " " . $row_users['lname']; ?></span>
            <p><?php echo $row_users['status']; ?></p>
          </div>
        </div>
        <?php }} ?>
      </div>
      <button id="create-group-chat-btn" class="create-group-chat-btn">Create Group Chat</button>
    </section>
  </div>
   <!-- Modal -->
<!-- Modal for selecting users -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Select users to create a group chat</h2>
      <span class="modal-close">&times;</span>
    </div>
    <div class="modal-body">
    <input type="text" name="group_name" placeholder="Group Name">
      <div class="users-list">
        <?php 
        $sql_users = mysqli_query($conn, "SELECT * FROM users WHERE unique_id != {$_SESSION['unique_id']}");
        if(mysqli_num_rows($sql_users) > 0){
          while($row_users = mysqli_fetch_assoc($sql_users)){
        ?>
        <div class="user" data-user-id="<?php echo $row_users['unique_id']; ?>">
          <div class="user-info">
            <img src="php/images/<?php echo $row_users['img']; ?>" alt="">
            <div class="details">
              <span><?php echo $row_users['fname'] . " " . $row_users['lname']; ?></span>
              <p><?php echo $row_users['status']; ?></p>
            </div>
          </div>
          <button class="add-user-btn">Add</button>
        </div>
        <?php }} ?>
        <div class="selected-users">
  <!-- Selected users will be added here dynamically -->
</div>

      </div>
    </div>
    <div class="modal-footer">
    <form id="create-group-chat-form" action="create_group_chat.php" method="POST">
        <input type="hidden" name="group_name" id="group_name_input" value="">
        <!-- Other hidden inputs for user IDs can be added here -->
        <button id="create-group-chat-modal-btn" class="create-group-chat-btn" style="display:none;">Create Group Chat</button>
        <button type="submit" class="create-group-chat-btn" style="display:none;"></button>
    </form>
</div>

  </div>
</div>



    
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>
      <script src="javascript/users.js"></script>
      <script>
document.addEventListener('DOMContentLoaded', function () {
    const createGroupChatBtn = document.getElementById('create-group-chat-btn');
    const modal = document.getElementById('myModal');
    const modalClose = document.querySelectorAll('.modal-close');
    const users = document.querySelector('.modal-body');
    const modalCreateBtn = document.getElementById('create-group-chat-modal-btn');
    const createGroupChatForm = document.getElementById('create-group-chat-form');
    const groupNameInput = document.getElementById('group_name_input');
    const selectedUsersContainer = document.querySelector('.selected-users');

    // Show modal when "Create Group Chat" button is clicked
    createGroupChatBtn.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    // Close modal when clicking on the close button or outside the modal
    modalClose.forEach(btn => {
        btn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Add event listener to each user's "Add" button
    users.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-user-btn')) {
            const user = event.target.closest('.user');
            const userId = user.dataset.userId;
            const userName = user.querySelector('.details span').textContent;
            const userStatus = user.querySelector('.details p').textContent;
            const userImage = user.querySelector('img').getAttribute('src');

            // Create a new selected user element
            const selectedUser = document.createElement('div');
            selectedUser.classList.add('user');
            selectedUser.innerHTML = `
                <img src="${userImage}" alt="">
                <div class="details">
                    <span>${userName}</span>
                    <p>${userStatus}</p>
                </div>
                <button class="remove-user-btn">Remove</button>
            `;
            selectedUser.dataset.userId = userId;

            // Add event listener to remove user button
            const removeBtn = selectedUser.querySelector('.remove-user-btn');
            removeBtn.addEventListener('click', function () {
                selectedUser.remove();
                checkSelectedUsers();
            });

            // Append selected user to container
            selectedUsersContainer.appendChild(selectedUser);

            // Toggle selected class on user
            user.classList.toggle('selected');

            // Check selected users to enable/disable create group chat button
            checkSelectedUsers();
        }
    });

    // Function to check if any users are selected to enable create group chat button
    function checkSelectedUsers() {
        const selectedUsers = document.querySelectorAll('.selected-users .user');
        if (selectedUsers.length > 1) {
            modalCreateBtn.style.display = 'block';
        } else {
            modalCreateBtn.style.display = 'none';
        }
    }

    // Event listener for create group chat button in modal
    modalCreateBtn.addEventListener('click', function () {
        const selectedUsers = document.querySelectorAll('.selected-users .user');
        const userIds = Array.from(selectedUsers).map(user => user.dataset.userId);
        const groupName = 'My Group'; // You can get the group name from an input if needed

        // Set the group name in the hidden input field
        groupNameInput.value = groupName;

        // Set the user_ids field in the form
        const userIDsInput = document.createElement('input');
        userIDsInput.setAttribute('type', 'hidden');
        userIDsInput.setAttribute('name', 'user_ids');
        userIDsInput.setAttribute('value', JSON.stringify(userIds));
        createGroupChatForm.appendChild(userIDsInput);

        // Submit the form
        createGroupChatForm.submit();
    });
});


</script>


    </body>
    </html>
    
