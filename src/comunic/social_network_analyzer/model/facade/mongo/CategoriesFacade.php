<?php

namespace comunic\social_network_analyzer\model\facade\mongo {

    use comunic\social_network_analyzer\model\repository\ICategoriesRepository;

    /**
     * class CategoriesFacade
     *
     */
    class CategoriesFacade {
        /** Aggregations: */

        /** Compositions: */
        /*         * * Attributes: ** */

        private $repository;

        /**
         * @param comunic\social_network_analyzer\model\repository\ICategoriesRepository $repository
         * @access public
         */
        public function __construct($repository) {
            $this->repository = $repository;
        }

        /**
         *
         *
         * @param string $categorie_text
         * @param  \comunic\social_network_analyzer\model\entity\parse\IObjectParser $parser
         * @return void
         * @access public
         */
        public function insert($category_text, $projectId, $parser) {
            $category = $parser->parse($category_text);
            $this->repository->insert($category, $projectId);
        }

// end of member function insert

        public function insertAll($category_text, $parser){
            $categories = $parser->parse($category_text);

            foreach ($categories as $category) {
               $this->repository->insert($category);
            }

        }

        /**
         *
         *
         * @param  string $categorie_text
         * @param  \comunic\social_network_analyzer\model\entity\parse\IObjectParser $parser
         * @return void
         * @access public
         */
        public function update($category_text, $parser, $projectId) {
            $category = $parser->parse($category_text);
            $this->repository->update($category, $projectId);
        }

// end of member function update

        /**
         *
         *
         * @param int $id
         * @param  \comunic\social_network_analyzer\model\entity\format\IObjectFormatter $fmt
         * @return string
         * @access public
         */
        public function findById($id, $fmt) {
            return $fmt->format($this->repository->findById($id));
        }

// end of member function findById

        /**
         *
         *
         * @param  int $id
         * @return void
         * @access public
         */
        public function delete($id, $idProject) {
           $this->repository->delete($id, $idProject);
        }

// end of member function delete

        /**
         *
         *
         * @param  \comunic\social_network_analyzer\model\entity\format\IObjectFormatter $fmt
         * @return string
         * @access public
         */
        public function listAll($fmt) {
            return $fmt->format($this->repository->listAll());
        }

// end of member function listAll
    }

} // end of CategoriesFacade
?>
