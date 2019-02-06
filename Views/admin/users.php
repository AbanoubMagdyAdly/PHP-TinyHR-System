<?php
$DB = new UsersDB(__TABLE_NAME__);

$current_page = isset($_GET["page"]) && is_numeric($_GET["page"]) ? $_GET["page"] : 0;

if ($DB->connect()) {
    $users_records = $DB->get_users(["username", "id", "email", "job", "hasphoto", "hascv"], $current_page * __RECORDS_PER_PAGE__); // this is an array of arrays
    $members_count = (array_values(($DB->get_members_count())[0]))[0];
}

if (isset($_GET["search"])) {
    $users_records = $DB->search($_GET["search"]);
}

$pg = new Pagination($current_page, $members_count);
$pg->handle_url_upper_limit();
$pg->handle_url_lower_limit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Table of Users</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href="views/admin/css/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="views/admin/css/style.css">


</head>

<body>
    <div class="s003">
        <form>
            <div class="inner-form">
                <div class="input-field second-wrap">
                    <input id="search" type="text" placeholder="Enter Keywords?" name="search" />
                </div>
                <div class="input-field third-wrap">
                    <button class="btn-search" type="button">
                        <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas"
                            data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-users">
        <div class="header">Users</div>


        <?php if (isset($users_records) && !empty($users_records)) {
            ?>
        <table cellspacing="0">
            <tr>
                <th>Picture</th>
                <th>Name</th>
                <th>Email</th>
                <th>Job</th>
                <th width="230">Comments</th>
            </tr>

            <?php
            foreach ($users_records as $user_record) {
                $image_src = $user_record["hasphoto"] == 1 ? "Files/Photos/" . $user_record["username"] : "Assets/default_avatar";
                echo "<tr>";
                echo "<td> <img src=$image_src" . ".jpg >" . "</td>";
                echo "<td>" . $user_record["username"] . "</td>";
                echo "<td>" . $user_record["email"] . "</td>";
                echo "<td>" . $user_record["job"] . "</td>";
                echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?id=" . $user_record['id'] . ">view more</a></td>";
                echo "</tr>";
            }

            if (isset($_GET["search"])) {
                echo "<a href=" . $_SERVER['PHP_SELF'] . "> show all </a>";
            } else {
                echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . $pg->nextPage() . "> next </a>";
                echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . $pg->prevPage() . "> previous </a>";
            }

            ?>
        </table>

        <?php 
    } else {
        echo 'no users are found found';
    }
    ?>
    </div>



</body>

</html>