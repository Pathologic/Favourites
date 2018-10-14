<?php namespace Pathologic\Favourites;

/**
 * Class Model
 * @package Pathologic\Favourites
 */
class Model {
    protected $data = array();
    protected $modx = array();

    /**
     * Model constructor.
     * @param \DocumentParser $modx
     */
    public  function __construct(\DocumentParser $modx)
    {
        $this->modx = $modx;
    }

    /**
     * @param $id
     */
    public function add($id) {
        $id = (int)$id;
        if ($id && !in_array($id, $this->data)) {
            $this->data[] = $id;
        }
    }

    /**
     * @param $id
     */
    public function remove($id) {
        $id = (int)$id;
        if ($id) {
            $data = array_flip($this->data);
            unset($data[$id]);
            $this->data = array_flip($data);
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function check($id) {
        $id = (int)$id;
        return $id && in_array($id, $this->data);
    }

    /**
     * @throws \Exception
     */
    public function load($name = 'favourites') {
        if (isset($this->modx->placeholders[$name])) {
            $this->data = &$this->modx->placeholders[$name];
        } else {
            $source = isset($_COOKIE[$name]) ? $_COOKIE[$name] : '';
            $ids = \APIhelpers::cleanIDs($source);
            if ($ids) {
                $_ids = implode(',', $ids);
                $q = $this->modx->db->query("SELECT `id` FROM {$this->modx->getFullTableName('site_content')} WHERE `published`=1 AND `deleted`=0 AND `id` IN ({$_ids})");
                $out = $this->modx->db->getColumn('id', $q);
                if ($out) {
                    $this->data = array_intersect($ids, $out);
                    $this->modx->placeholders[$name] = &$this->data;
                }
            }
        }
    }


    /**
     * @return int
     */
    public function count() {
        return count($this->data);
    }

    /**
     *
     */
    public function save($name = 'favourites') {
        $ids = implode(',', $this->data);
        setcookie(
            $name,
            $ids,
            time() + 365 * 24 * 60 * 60,
            MODX_BASE_URL,
            '',
            $this->modx->getConfig('server_protocol') == 'http',
            true
        );

        return $this->count();
    }

    /**
     * @return array
     */
    public function getItems() {
        return $this->data;
    }
}
