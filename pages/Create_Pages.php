<?php
require_once dirname(__DIR__)."/includes/db_Scores.php";


function Create_Menu_Page(){
    ?>
    <div>
        <h1>Lottery Chance</h1>
        <table>
            <thead>
                <tr>
                <th>id</th>
                <th>username</th>
                <th>score</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $users = wp_LC_Read_user();
                    foreach($users as $user){
                        $username = $user["username"];
                        $userid = $user["ID"];
                        $userScore = $user["score"];
                        echo "<tr>";
                        echo "<td>$userid</td>";
                        echo "<td>$username</td>";
                        echo "<td>$userScore</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}