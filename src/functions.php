<?php

function verifParams(){
  if(isset($_POST) && sizeof($_POST)>0){
    foreach ($_POST as $key => $value) {
     $data = trim($value);
     $data = stripslashes($data);
     $data = strip_tags($data);
     $data = htmlspecialchars($data);
     $_POST[$key] = $data;
    }
    // print_r($_POST);exit();
  }
}

    function displayAccueil(){
        $result = '<h1> Bienvenu sur la page d\'Accueil</h1>';
        $result .='
        <div class="bg-white shadow-sm rounded p-6">
            <form class="" action="actionInscription" method="post">
              <div class="mb-4">
                <h2 class="h4">INSCRIPTION</h2>
              </div>

              <!--Input-->
              <div class="mb-3">
                <div class="input-group input-group form">
                  <input type="text" name="pseudo" class="form-control" value="Mario" placeholder="Entrer votre Pseudo" required="">
                </div>
              </div>
              <!--End Input-->
              
              <!--Input-->
              <div class="mb-3">
                  <div class="input-group input-group form">
                    <input type="email" name="email" class="form-control" value="mario@gmail.com" placeholder="Entrer votre email" required="">
                  </div>
              </div>
              <!--End Input-->

              <!-- Input-->
              <div class="mb-3">
                  <div class="input-group input-group form">
                    <input type="password" name="password" class="form-control" value="mario2023" placeholder="Entrer votre mot de passe" required="">
                  </div>
              </div>
               <!--End Input-->

              <button type="submit" class="btn btn-block btn-primary">S\'inscrire</button>

            </form>
        </div>';
        
        
        return $result;

    };
    
    function displayActionInscription(){
      global $model;
      // print_r($_POST);exit();
      $pseudo = $_POST["pseudo"];
      $email = $_POST["email"];
      $password = $_POST["password"];

      $data = $model->createCustomers($pseudo,$email,$password);
      if($data){
        // Inscription réussie
        $data_customer = $model->authentifier($email,$password);
        if($data_customer){
          $_SESSION["customer"] = $data_customer;
          return '<p class="btn btn-success btn-block">Inscription réussie '.$pseudo.', vous êtes bien connecté</p>'.displayProduit();
        }
      }else{
        // Inscription échoué
        return '<p class=" btn btn-danger btn-block">Inscription échoué</p>'.displayProduit();
      }

    }

    function displayActionConnexion(){
      global $model;
      // print_r($_POST);exit();
      $email = $_POST["email"];
      $password = $_POST["password"];
      $data_customer = $model->authentifier($email,$password);
      if($data_customer){
        $_SESSION["customer"] = $data_customer;
        return '<p class="btn btn-success btn-block">Authentification réussie, vous êtes bien connecté</p>'.displayProduit();
      }else{
        // Inscription échoué
        return '<p class=" btn btn-danger btn-block">Authentification échoué</p>'.displayProduit();
      }
    }

    function displayDeconnexion(){
      unset($_SESSION["customer"]);
      return '<p class="btn btn-success btn-block">Déconnexion réussie</p>'.displayProduit();
    }  

    function displayContact(){
        $result = '<h1> Bienvenu sur la page de Contact</h1>';
        $result .='
        <h1 class="text-center"> Contactez-Nous !</h1>
        <form>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail">Nom :</label>
              <input type="eamil" class="form-control" id="inputEmail" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword2">Prenom :</label>
              <input type="text" class="form-control" id="inputEmail" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputAdress">Email :</label>
            <input type="text" class="form-control" id="inputAdress" placeholder="" required>
          </div>
          <div class="form-group">
            <label for="inputAdress2">Message :</label>
            <textarea class="form-control row="5" col="80"  required></textarea>
          </div>

          <div class="form-group">
             <div class="form-check">
             <input class="form-check-input" type="checkbox" id="">
                <label class="form-check-label" for=""> 
                  Se rappeler de moi
                </label>   
             </div>
          </div>
          <button type="submit" class="btn btn-success">Envoyer</buton>

        </form>
        ';


        


        return $result;
    }

    function displayProduit(){
        global $model;
        $dataProduct = $model->getProduct();
        $result = '<h1> Bienvenu sur la page  Produits</h1>';
        foreach ( $dataProduct as $key => $value) {
           $result .= '<div class="card" style="width: 18rem; display:inline-block;">
           <img src="'.BASE_URL.SP."images".SP."produit".SP.$value["image"].'" class="card-img-top" alt="...">
           <div class="card-body">
             <h5 class="card-title">'.$value["name"].'</h5>
             <a href="'.BASE_URL.SP."details".SP.$value["id"].'" class="btn btn-primary">Détails</a>
             <a href="'.BASE_URL.SP."panier".SP.$value["id"].'" class="btn btn-success">Acheter</a>
           </div>
         </div>';

        }

        return $result;

    }   

    function displayCategory(){
        global $model;
        global $url;
        global $category;
        if(isset($url[1]) && is_numeric($url[1]) && $url[1]>0 &&  $url[1] <= sizeof($category)){
            $result = '<h1> Produit de la catégorie '.$category[$url[1]-1]["name"].' </h1>';
            $dataProduct = $model->getProduct(null,$url[1]);
            
            foreach ( $dataProduct as $key => $value) {
                $result .= '<div class="card" style="width: 18rem; display:inline-block;">
                <img src="'.BASE_URL.SP."images".SP."produit".SP.$value["image"].'" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">'.$value["name"].'</h5>
                  <a href="'.BASE_URL.SP."details".SP.$value["id"].'" class="btn btn-primary">Détails</a>
                  <a href="'.BASE_URL.SP."panier".SP.$value["id"].'" class="btn btn-success">Acheter</a>
                </div>
              </div>';
     
            }

        }else{
            $result = '<h1> URL incorrecte !</h1>';
        }
  

        return $result;
    } 

    function displayDetails(){
        global $model;
        global $url;
        global $category;
        $result = '<h1> Bienvenu sur la page  de d"tails produits </h1> ';
        $dataProduct = $model->getProduct(null,null,$url[1]);
        // print_r($dataProduct);exit();

        $result .='
            <div class="row details"> 
              <div class="col-md-5 col-12"> 
                <img src="'.BASE_URL.SP."images".SP."produit".SP.$dataProduct[0]["image"].'" class="card-img-top" alt="...">
              </div> 
              <v class="col-md-7 col-12">       
                  <h2>'.$dataProduct[0]["name"].'</h2>
                  <p>'.$dataProduct[0]["description"].'</p>
                  <p>Catégorie : '.$category[$dataProduct[0]["category"]-1]["name"].'</p>
                  <a href="'.BASE_URL.SP."panier".SP.$dataProduct[0]["id"].'" class="btn btn-block btn-success"> Ajouter au panier</a>  
                  <a href="'.BASE_URL.SP."produit".'" class="btn btn-block btn-primary"> Retour Page Produit </a>  
              </div> 
            </div> 
      ';

        return $result;
    }

    function displayPanier(){
        global $model;
        global $url;
        if(isset($url[1])){
            $idProduit = $url[1];
            $dataProduct = $model->getProduct(null,null,$url[1]);
            $_SESSION["panier"][] = $dataProduct[0];
        }
        
        if(!isset($_SESSION["panier"]) || sizeof($_SESSION["panier"])==0){
            return '<h1> Votre panier est vide</h1>'.displayProduct();
        }
           $result = '<table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Quantité</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                  
         ';
         $total_price = 0;
          // print_r($_SESSION);exit();

         foreach ($_SESSION["panier"] as $key => $value ) {
          // print_r($value);exit();
        
             $total_price +=  $value["price"];
             $result .= '<tr>
             <th scope="row">'.$value["id"].'</th>
             <td>'.$value["name"].'</td>
             <td>'.$value["description"].'</td>
             <td><img src="'.BASE_URL.SP."images".SP."produit".SP.$value["image"].'" alt="..."/></td>
             <td>'.$value["price"].'€</td>
             <td>1</td>
             <td><a href="'.BASE_URL.SP."supprimer".SP.$key.'" class="btn btn-primary">Supprimer</a></td>
           </tr>';
           
            
        }
        $total_tva = $total_price*TVA/100;
        $total_ttc = $total_tva+$total_price;
        $result .= '<tr><td></td><td></td><td></td><td>Prix total(HT)</td><td>'.number_format($total_price,2).'</td><td></td></tr>
                 <tr><td></td><td></td><td></td><td>Tva ('.TVA.')</td><td>'.number_format($total_tva,2).'</td><td></td></tr>
                 <tr><td></td><td></td><td></td><td>Total (TTC)</td><td>'.number_format($total_ttc,2).'</td><td></td></tr>'; 

        $result = ' 
           </tbody>
        </table>';

        $result .= '<a href="'.BASE_URL.SP."validationCommande".'" class="btn btn-success btn-block">Valider votre commande</a>';
        return $result;
    } 

    function displaySupprimer(){
      global $url;
      // print_r ($_SESSION["panier"]);exit();
      if(isset($url[1]) && is_numeric($url[1])){
 
        $param = $url[1];
        unset($_SESSION["panier"][$param]);
        header("Location: ".BASE_URL.SP."panier");
      }
    }

    function displayProfil(){
      if(isset($_SESSION['customer']["sexe"])){
        if($_SESSION['customer']["sexe"]==1){
          $_SESSION['customer']["sexe"] = "Masculin";
        }else{
          $_SESSION['customer']["sexe"] = "Feminin";
        }
        
      }
      $result = '
      <ul class="list-group">
      <li class="list-group-item active">Bienvenu sur votre profil '.$_SESSION['customer']["pseudo"].'</li>
      <li class="list-group-item">Sexe : '.$_SESSION['customer']["sexe"].'</li>
      <li class="list-group-item">Pseudo : '.$_SESSION['customer']["pseudo"].'</li>
      <li class="list-group-item">Nom : '.$_SESSION['customer']["firstname"].'</li>
      <li class="list-group-item">Prenom : '.$_SESSION['customer']['lastname'].'</li>
      <li class="list-group-item">Email : '.$_SESSION['customer']['email'].'</li>
      <li class="list-group-item">Description : '.$_SESSION['customer']['description'].'</li>
      <li class="list-group-item">Adresse Livraison : '.$_SESSION['customer']['adresse_livraison'].'</li>
      <li class="list-group-item">Adresse Facturation : '.$_SESSION['customer']['adresse_facturation'].'</li>
       </ul>

     <div class="mt-2">
      <a href="'.BASE_URL.SP."updateProfil".'" class="btn btn-success">Mettre à jour mes données</a>
     </div>
      ';

      return $result;
    }

    function displayUpdateProfil(){
      $result = '
      <form  action="updateAction" method="post">
        <div class="form-row">

         <div class="input-group mb-3">
          <div class="input-group-prepend">
          <label for="inputGroupSelect01" class="input-group-text">Sexe</label>
        </div>
        <select name="sexe" id="inputGroupSelect01" class="custom-select">
              <option selected>choose...</option>
              <option value="1">Masculin</option>
              <option value="2">Feminin</option>
        </select>
         </div>
        <div class="form-group col-md-3">
          <label for="inputEmail4">Nom </label>
          <input type="text" name="firstname" value="'.$_SESSION['customer']["firstname"].'" class="form-control" id="inputEmail4">
        </div>
        <div class="form-group col-md-3">
          <label for="inputPassword4">Prenom</label>
          <input type="text" name="lastname" value="'.$_SESSION['customer']["lastname"].'" class="form-control" id="inputPassword4">
        </div>
        <div class="form-group col-md-3">
          <label for="inputPassword4">Email</label>
          <input type="email" name="email" value="'.$_SESSION['customer']["email"].'" class="form-control" id="inputPassword4">
        </div>
        <div class="form-group col-md-3">
          <label for="inputPassword4">Téléphone</label>
          <input type="text" name="tel" value="'.$_SESSION['customer']["tel"].'" class="form-control" id="inputPassword4">
        </div>
         </div>
         <div class="form-group">
        <label for="inputAddress">Description</label>
        <input type="text" name="description" value="'.$_SESSION['customer']["description"].'" class="form-control" id="inputAddress" placeholder="1234 Main St">
         </div>
         <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputPassword4">Adresse de Facturation</label>
          <input type="text" name="adresse_facturation" value="'.$_SESSION['customer']["adresse_facturation"].'" class="form-control" id="inputPassword4">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Adresse de Livraison</label>
          <input type="text" name="adresse_livraison" value="'.$_SESSION['customer']["adresse_livraison"].'" class="form-control" id="inputPassword4">
        </div>
         </div>
      
         <button type="submit" class="btn btn-success">Mettre à jour</button>
      </form>';

       return $result;
    }

    function displayUpdateAction(){
      global $model;
      $_POST["id"] = $_SESSION["customer"]["id"];
      // print_r($_POST)exit();
      $r = $model->updateInfosCustomer($_POST);
      if($r){
        $_SESSION["customer"] = $model->getCustomer($_SESSION["customer"]["id"]);
        $result = '<p class="btn btn-success btn-block">Mise à jour réussie</p>';
      }else{
        $result = '<p class="btn btn-danger btn-block">Mise à jour échouée</p>';
      }

      return $result.displayProfil();
    }

    function displayValidationCommande(){
      global $model;
      if(isset($_SESSION["customer"])){// l'utilisateur est connecté
        $dataCustomer = $_SESSION["customer"];
        // print_r($_SESSION["panier"]);exit();
        foreach ($_SESSION["panier"] as $key => $value) {
        $r = $model->createOrders($dataCustomer["id"],$value["id"],1,$value["price"]);
        if($r){
           return " Validation du commande échouée";
        }
      }
      unset($_SESSION["panier"]);
      $rsult = " Validation de la commande réussie. vous pouvez passer recupérer en magasin dans 30min";
      }else{// l'utilisateur n'est pas connecté
        $result = '<p class="btn btn-danger btn-block">Connectez-vous pour pouvoir valider votre commande</p>';
        $result .= displayAccueil();
      }
      return $result;
    }

?> 