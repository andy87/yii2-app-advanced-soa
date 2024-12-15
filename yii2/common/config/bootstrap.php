<?php
$dirApp = dirname(__DIR__, 2);

Yii::setAlias('@common', "$dirApp/common");
Yii::setAlias('@frontend', "$dirApp/frontend");
Yii::setAlias('@backend', "$dirApp/backend");
Yii::setAlias('@console', "$dirApp/console");
