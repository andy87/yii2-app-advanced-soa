<?php

$root = dirname(__DIR__, 3);

Yii::setAlias('@root', $root);

Yii::setAlias('@uploads', "$root/uploads");

$app = "$root/app";

Yii::setAlias('@app', $app);

Yii::setAlias('@common', "$app/common");
Yii::setAlias('@frontend', "$app/frontend");
Yii::setAlias('@backend', "$app/backend");
Yii::setAlias('@console', "$app/console");

