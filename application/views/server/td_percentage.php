<div class="progress">
                <div class="<?php echo getProgressBar($percents); ?>" role="progressbar" aria-valuenow="<?php echo $percents; ?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 20px; width: <?php echo $percents; ?>%;">
                <?php echo $percents; ?>%
                </div>
            </div>