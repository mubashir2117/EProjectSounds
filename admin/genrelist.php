<?php
include "header.php";
?>

<?php
include ("config.php");
$query = "Select * from `genre`";
$result = mysqli_query($conn,$query);
$count = mysqli_num_rows($result);
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="page-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Genres</h2>
                    <p class="panel-subtitle"><?php echo $count; ?> genre(s) defined for the music library</p>
                </div>
                <a class="btn btn-add" href="genre.php"><i class="fa-solid fa-plus"></i> Add Genre</a>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Genre</th>
                            <th class="th-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($count > 0) {
                        while($data = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><span class="badge-soft">#<?php echo $data["id"]; ?></span></td>
                            <td class="cell-title"><?php echo htmlspecialchars($data["genre_name"]); ?></td>
                            <td class="actions-cell">
                                <a class="btn btn-edit" href="editgenre.php?id=<?php echo $data["id"]; ?>" title="Edit genre">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <a class="btn btn-delete" href="delete.php?id=<?php echo $data["id"]; ?>" title="Delete genre" onclick="return confirm('Are you sure you want to delete this genre?');">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="fa-solid fa-tags"></i>
                                    <p>No genres yet. Click "Add Genre" to get started.</p>
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
