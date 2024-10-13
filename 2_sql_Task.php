<?php

SELECT `first_name`, `last_name`, `model`, GROUP_CONCAT(`name`) AS `childs`  FROM `worker`
INNER JOIN `car` ON car.user_id = id
LEFT JOIN `child` ON child.user_id = id
GROUP BY `id`