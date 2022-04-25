<?php
require '../head.php';
require_once '../database/credentials.php';


$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//class was container-fluid, maybe a bootstrap thing idk
echo <<<_END
        <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
_END;


$query = "SELECT * FROM staff";

//edit_users.php does not exist as of 11/04.
//nor delete_users.php.


//not showing passwords of staff members
//job role being drop down menu to change?
$results = mysqli_query($connection, $query);
while($rows = mysqli_fetch_assoc($results)){
    echo "<tr>";
    echo "<td>{$rows['username']}</td><td>{$rows['firstname']}</td><td>{$rows['lastname']}</td><td>{$rows['job_role']}</td>"; 
    
    echo '<td>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal'.$rows['username'].'">Edit</button>

    <div class="modal fade"id="editModal'.$rows['username'].'" tabindex="-1" aria-labelledby="editModalLabel'.$rows['username'].'" aria-hidden="true">
    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User Information</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method = "POST" action ="edit_users.php">
                                    <label for="username" id ="username">Username</label></br>
                                    <input name="username" type="text" value ="'.$rows['username'].'"><br/>

                                    <label for="firstname" id ="firstname">First name</label></br>
                                    <input name="firstname" type="text" value ="'.$rows['firstname'].'"><br/>

                                    <label for="lastname" id ="lastname">Last name</label></br>
                                    <input name="lastname" type="text" value ="'.$rows['lastname'].'"><br/>

                                    <label for="job_role" id ="job_role">Job Role</label></br>
                                    <input name="job_role" type="text" value ="'.$rows['job_role'].'"><br/>


                                    <label for="password" id ="password">User Password</label></br>
                                    <input name="password" type="text" value ="'.$rows['password'].'"><br/>

                        </div>
                        <form class="modal-footer" method="POST" action="edit_users.php">
                            <button type="submit" class="btn btn-success" name="staff" value="'.$rows['username'].'">Submit Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                </div>
            </div>
        </div> 
        </td>';







    echo '<td>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$rows['username'].'">Delete</button> 
            
            <div class="modal fade"id="deleteModal'.$rows['username'].'" tabindex="-1" aria-labelledby="deleteModalLabel'.$rows['username'].'" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete User?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                            <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                        </div>
                        <form class="modal-footer" method="POST" action="delete_users.php">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="staff" value="'.$rows['username'].'">Yes</button>
                        </form>
                    </div>
                </div>
            </div>


    </td>';

    echo "</tr>";
    
}

echo <<<_END
    </tbody>
    </thead>
    <div>
_END;

//require '../footer.php';

?>