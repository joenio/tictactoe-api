<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
#require_once "vendor/autoload.php";

function getEntityManager() {
  $isDevMode = true;
  $config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/../src/classes'), $isDevMode);
  $conn = array(
      'driver' => 'pdo_sqlite',
      'path' => __DIR__ . '/../db.sqlite',
  );
  // obtaining the entity manager
  $entityManager = Doctrine\ORM\EntityManager::create($conn, $config);
  return $entityManager;
}
