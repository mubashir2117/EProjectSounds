<?php
include "header.php";
?>

<?php
include ("config.php");

$query10 = "SELECT * FROM `artist` inner join genre where genre.id = artist.genre_id";
$result10 = mysqli_query($conn,$query10);
$count10 = mysqli_num_rows($result10);
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="page-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Artists</h2>
                    <p class="panel-subtitle"><?php echo $count10; ?> artist(s) currently featured on Sound Music</p>
                </div>
                <a class="btn btn-add" href="artist.php"><i class="fa-solid fa-plus"></i> Add Artist</a>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Artist</th>
                            <th>Genre</th>
                            <th class="th-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($count10 > 0) {
                        while($data10 = mysqli_fetch_assoc($result10)){ ?>
                        <tr>
                            <td>
                                <div class="media-cell">
                                    <img class="avatar" src="<?php echo $data10["artist_image"]; ?>" alt="<?php echo htmlspecialchars($data10["artist_name"]); ?>" onerror="this.src='../assets/images/avatar.png'">
                                    <div class="cell-title"><?php echo htmlspecialchars($data10["artist_name"]); ?></div>
                                </div>
                            </td>
                            <td><span class="badge-soft"><?php echo htmlspecialchars($data10["genre_name"]); ?></span></td>
                            <td class="actions-cell">
                                <a class="btn btn-edit" href="editartist.php?getid=<?php echo $data10['Artist_id']?>" title="Edit artist">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <a class="btn btn-delete" href="deleteartist.php?delid=<?php echo $data10['Artist_id']?>" title="Delete artist" onclick="return confirm('Are you sure you want to delete this artist?');">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="fa-solid fa-user-slash"></i>
                                    <p>No artists yet. Click "Add Artist" to get started.</p>
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
?>
