<?php
include 'header.php';
?>

<?php
include ("config.php");

$qry1 = "SELECT * FROM `song` join genre on genre.id = song.genre_id join artist on artist.Artist_id = song.Artists_id";
$res1 = mysqli_query($conn,$qry1);
$count1 = mysqli_num_rows($res1);
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="page-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Songs</h2>
                    <p class="panel-subtitle"><?php echo $count1; ?> song(s) in the music library</p>
                </div>
                <a class="btn btn-add" href="song.php"><i class="fa-solid fa-plus"></i> Add Song</a>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Song</th>
                            <th>Preview</th>
                            <th>Year</th>
                            <th>Genre</th>
                            <th>Artist</th>
                            <th class="th-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($count1 > 0) {
                        while($data1 = mysqli_fetch_assoc($res1)){ ?>
                        <tr>
                            <td>
                                <div class="media-cell">
                                    <img class="avatar" src="<?php echo $data1["song_image"]; ?>" alt="<?php echo htmlspecialchars($data1["song_name"]); ?>" onerror="this.src='../assets/images/avatar.png'">
                                    <div class="cell-title"><?php echo htmlspecialchars($data1["song_name"]); ?></div>
                                </div>
                            </td>
                            <td>
                                <audio controls preload="none">
                                    <source src="<?php echo $data1["song_file"]; ?>" type="audio/mpeg">
                                </audio>
                            </td>
                            <td><span class="badge-soft"><?php echo $data1["years"]; ?></span></td>
                            <td><?php echo htmlspecialchars($data1["genre_name"]); ?></td>
                            <td><?php echo htmlspecialchars($data1["artist_name"]); ?></td>
                            <td class="actions-cell">
                                <a class="btn btn-edit" href="editsong.php?editsid=<?php echo $data1['song_id']?>" title="Edit song">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <a class="btn btn-delete" href="deletesong.php?delsid=<?php echo $data1['song_id']?>" title="Delete song" onclick="return confirm('Are you sure you want to delete this song?');">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fa-solid fa-music"></i>
                                    <p>No songs yet. Click "Add Song" to get started.</p>
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
