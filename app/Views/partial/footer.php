<?php

use Config\OSPOS;

?>

        </div>
    </div>

    <div id="footer">
        <div class="jumbotron push-spaces">
            <strong>
                <?= lang('Common.copyrights', [date('Y')]) ?> ·
                <a href="https://opensourcepos.org" target="_blank"><?= lang('Common.website') ?></a> ·
                <?= esc(config('App')->application_version) ?> -
                <strong><?= lang('Common.software_title') ?></strong>
            </strong>.
        </div>
    </div>
</body>

</html>
