<?php namespace Pathologic\Favourites;
include_once (MODX_BASE_PATH . 'assets/lib/Helpers/Config.php');
include_once (MODX_BASE_PATH . 'assets/snippets/DocLister/lib/DLTemplate.class.php');
/**
 * Created by PhpStorm.
 * User: Pathologic
 * Date: 09.10.18
 * Time: 2:10
 */
class Actions {
    protected $modx = null;
    protected $config = null;
    /**
     * @var Model $model
     */
    protected $model = null;
    protected $id = 0;
    protected $cookieName = 'favourites';

    /**
     * Actions constructor.
     * @param \DocumentParser $modx
     * @param array $cfg
     * @throws \Exception
     */
    public function __construct(\DocumentParser $modx, $cfg = array())
    {
        $this->modx = $modx;
        $this->config = new \Helpers\Config();
        if (isset($cfg['config'])) {
            $this->config->loadConfig($cfg['config']);
        }
        $this->config->setConfig($cfg);
        $this->model = new $cfg['model']($modx);
        $this->id = (int)$this->getCFGDef('id', $this->modx->documentIdentifier);
        $this->cookieName = $this->getCFGDef('cookieName', 'favourites');
        $this->model->load($this->cookieName);
    }

    /**
     * @return int
     */
    public function add() {
        $this->model->add($this->id);

        return $this->model->save($this->cookieName);
    }

    /**
     * @return int
     */
    public function remove() {
        $this->model->remove($this->id);

        return $this->model->save($this->cookieName);
    }

    /**
     * @return int
     */
    public function count() {
        return $this->model->count();
    }

    /**
     * @return string
     */
    public function check() {
        $addTpl = $this->getCFGDef('addTpl', '@CODE:<a class="btn favourites" data-id="[+id+]" href="#">Избранное</a>');
        $removeTpl = $this->getCFGDef('removeTpl', '@CODE:<a class="btn favourites active" data-id="[+id+]" href="#">Избранное</a>');
        $tpl = $this->model->check($this->id) ? $removeTpl : $addTpl;

        return \DLTemplate::getInstance($this->modx)->parseChunk($tpl, ['id' => $this->id]);
    }

    /**
     * @return mixed
     */
    public function getItems() {
        return $this->model->getItems();
    }

    /**
     * @return string
     */
    public function listItems() {
        $params = $this->config->getConfig();
        $params['idType'] = 'documents';
        $params['documents'] = implode(',', $this->model->getItems());

        return $this->modx->runSnippet($this->getCFGDef('snippetName', 'DocLister'), $params);
    }

    /**
     * @param $name
     * @param string $default
     * @return mixed
     */
    public function getCFGDef($name, $default = '')
    {
        return $this->config->getCFGDef($name, $default);
    }
}
