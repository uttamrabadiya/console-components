<div class=" mx-2 mb-1 mt-<?php echo $marginTop ?>">
    <table class="table-auto">
        <thead>
        <tr>
            <?php foreach ($headers as $header) {?>
                <th><?php echo $header; ?> </th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row) {?>
            <tr>
                <?php foreach($row as $column) { ?>
                    <td><?php echo $column; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
