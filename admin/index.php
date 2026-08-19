<?php
session_start();

if($_SESSION['user_id']){

    include("config.php");
    include ("header.php");

    $query = "SELECT * FROM `contact` ORDER BY created_at DESC";
    $result = mysqli_query($conn,$query);
    $count = mysqli_num_rows($result);
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="page-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Contact Submissions</h2>
                    <p class="panel-subtitle"><?php echo $count; ?> message(s) received from the website</p>
                </div>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($count > 0) {
                        while($data = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class="cell-title"><?php echo htmlspecialchars($data["c_name"]); ?></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($data["c_email"]); ?>" style="color:var(--admin-accent-strong);font-weight:600;"><?php echo htmlspecialchars($data["c_email"]); ?></a></td>
                            <td><?php echo htmlspecialchars($data["reviews"]); ?></td>
                            <td style="max-width:360px;"><?php echo htmlspecialchars($data["message"]); ?></td>
                            <td><?php echo htmlspecialchars($data["created_at"]); ?></td>
                        </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fa-solid fa-inbox"></i>
                                    <p>No contact submissions yet.</p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php
include "footer.php";
}
else{
    echo "<script>window.location.href = 'login.php';</script>";
}
?>
