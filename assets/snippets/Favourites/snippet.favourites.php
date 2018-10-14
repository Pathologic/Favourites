<?php
if (empty($controller) || !class_exists($controller)) {
    include_once ('actions.php');
    $controller = 'Pathologic\\Favourites\\Actions';
}
if (empty($model) || !class_exists($model)) {
    include_once ('model.php');
    $params['model'] = 'Pathologic\\Favourites\\Model';
}
$controller = new $controller($modx, $params);
if (!isset($includeJs) || $includeJs) {
    $modx->regClientScript(MODX_SITE_URL . 'assets/snippets/Favourites/js/favourites.js', 'favourites');
    $modx->regClientScript('<script>Favourites.connector = \'' . MODX_SITE_URL . 'assets/snippets/Favourites/ajax.php' . '\'</script>', 'favourites-setup');
}
if (!empty($action) && method_exists($controller, $action)) {
    return call_user_func(array($controller, $action));
}
