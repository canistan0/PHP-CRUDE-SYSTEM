<tr>
    <td><?php print($rowUser['id']); ?> </td>

    <td>
        <a href="form.php?edit_id=<?php print($rowUser['id']); ?>"><!-- Link to the edit form, passing the user's ID as the 'edit_id' parameter -->
            <?php print($rowUser['name']); ?>
        </a>
    </td>

    <td><?php print($rowUser['email']); ?> </td>
</tr>


<tr>
    <td>
        <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['id']); ?>">
            <span data-feather="trash"></span>
        </a>
    </td>
</tr>



// sidebar.php




//dashboard