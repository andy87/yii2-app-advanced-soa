<?php
$dirApp = dirname(__DIR__, 2);
$root = dirname(__DIR__, 3);

Yii::setAlias('@root', $root);
Yii::setAlias('@yii2', "$root/yii2");
Yii::setAlias('@runtime', "$root/runtime");
Yii::setAlias('@uploads', "$root/uploads");
Yii::setAlias('@runtimeFrontend', "$root/runtime/frontend");
Yii::setAlias('@runtimeBackend', "$root/runtime/backend");
Yii::setAlias('@runtimeConsole', "$root/runtime/console");
Yii::setAlias('@runtimeDocker', "$root/runtime/Docker");
Yii::setAlias('@common', "$dirApp/common");
Yii::setAlias('@frontend', "$dirApp/frontend");
Yii::setAlias('@backend', "$dirApp/backend");
Yii::setAlias('@console', "$dirApp/console");
