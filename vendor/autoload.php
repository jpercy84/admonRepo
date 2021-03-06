<?php

// autoload.php @generated by Composer

include "core/controller/Core.php";
include "core/controller/View.php";
include "core/controller/Module.php";
include "core/controller/Database.php";
include "core/controller/Executor.php";
//# include "controller/Session.php"; [remplazada]

include "core/controller/forms/lbForm.php";
include "core/controller/forms/lbInputText.php";
include "core/controller/forms/lbInputPassword.php";
include "core/controller/forms/lbValidator.php";

// 10 octubre 2014
include "core/controller/Model.php";
include "core/controller/Bootload.php";
include "core/controller/Action.php";

// 13 octubre 2014
include "core/controller/Request.php";


// 14 octubre 2014
include "core/controller/Get.php";
include "core/controller/Post.php";
include "core/controller/Cookie.php";
include "core/controller/Session.php";
include "core/controller/Lb.php";

// 26 diciembre 2014
include "core/controller/Form.php";

// 22 agosto 2015



require_once __DIR__ . '/composer/autoload_real.php';

return ComposerAutoloaderInit4e541d597c785b0ded0ff779817543f2::getLoader();
