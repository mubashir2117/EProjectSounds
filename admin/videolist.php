<?php
include 'header.php';
?>

<?php
include ("config.php");
$query = "SELECT * FROM `video` join genre on genre.id = video.genre_id join artist on artist.Artist_id = video.Artists_id";
$result = mysqli_query($conn,$query);
$count = mysqli_num_rows($result);
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="page-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Videos</h2>
                    <p class="panel-subtitle"><?php echo $count; ?> video(s) in the library</p>
                </div>
                <a class="btn btn-add" href="video.php"><i class="fa-solid fa-plus"></i> Add Video</a>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Video</th>
                            <th>Preview</th>
                            <th>Year</th>
                            <th>Genre</th>
                            <th>Artist</th>
                            <th class="th-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($count > 0) {
                        while($data = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class="cell-title"><?php echo htmlspecialchars($data["video_name"]); ?></td>
                            <td>
                                <video width="180" height="110" controls preload="none">
                                    <source src="<?php echo $data['video_file'] ?>" type="video/mp4">
                                </video>
                            </td>
                            <td><span class="badge-soft"><?php echo $data["years"]; ?></span></td>
                            <td><?php echo htmlspecialchars($data["genre_name"]); ?></td>
                            <td><?php echo htmlspecialchars($data["artist_name"]); ?></td>
                            <td class="actions-cell">
                                <a class="btn btn-edit" href="editvideo.php?editvideoid=<?php echo $data['video_id']?>" title="Edit video">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <a class="btn btn-delete" href="deletevideo.php?delvideoid=<?php echo $data['video_id']?>" title="Delete video" onclick="return confirm('Are you sure you want to delete this video?');">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fa-solid fa-video"></i>
                                    <p>No videos yet. Click "Add Video" to get started.</p>
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
