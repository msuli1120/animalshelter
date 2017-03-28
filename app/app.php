<?php
  date_default_timezone_set('America/Los_Angeles');
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Animal.php";
  require_once __DIR__."/../src/Type.php";

  $app = new Silex\Application();

  $server = 'mysql:host=localhost:8889;dbname=animal_shelter';
  $user = 'root';
  $pass = 'root';
  $db = new PDO($server,$user,$pass);

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  use Symfony\Component\HttpFoundation\Request;
  Request::enableHttpMethodParameterOverride();

  $app->get("/", function () use ($app) {
    return $app['twig']->render('index.html.twig');
  });

  $app->post("/add", function () use ($app) {
    $new_animal = new Animal ($_POST['name'], $_POST['gender'], $_POST['breed'], $_POST['optradio']);
    $new_animal->save();
    return $app['twig']->render('index.html.twig');
  });

  $app->post("/checkall", function () use ($app) {
    $results = Animal::getAll();
    return $app['twig']->render('list.html.twig', array('results'=>$results));
  });

  $app->post("/dogs", function () use ($app) {
    $results = Animal::getTypeAnimals($_POST['dogs']);
    return $app['twig']->render('dogslists.html.twig', array('results'=>$results));
  });

  $app->post("/cats", function () use ($app) {
    $results = Animal::getTypeAnimals($_POST['cats']);
    return $app['twig']->render('catslists.html.twig', array('results'=>$results));
  });

  $app->post("/bunnys", function () use ($app) {
    $results = Animal::getTypeAnimals($_POST['bunnys']);
    return $app['twig']->render('bunnyslists.html.twig', array('results'=>$results));
  });

  $app->get("/dogs/{id}", function($id) use ($app) {
    $results = Animal::find($id);
    return $app['twig']->render('index.html.twig', array('results'=>$results));
});

$app->get("/cats/{id}", function($id) use ($app) {
  $results = Animal::find($id);
  return $app['twig']->render('index.html.twig', array('results'=>$results));
});

$app->get("/bunnys/{id}", function($id) use ($app) {
  $results = Animal::find($id);
  return $app['twig']->render('index.html.twig', array('results'=>$results));
});

$app->get("/animals/{id}/edit", function ($id) use ($app) {
  $results = Animal::find($id);
  return $app['twig']->render('edit.html.twig', array('results'=>$results));
});

$app->patch("/animals/{id}", function ($id) use ($app) {
   $name = $_POST['name'];
   $gender = $_POST['gender'];
   $breed = $_POST['breed'];
   $animal = Animal::find($id);

   $new_animal->update($name,$gender,$breed);
   return $app['twig']->render('category.html.twig');
});

  return $app;
?>
