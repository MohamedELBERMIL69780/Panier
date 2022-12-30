

<?php 
   
   include_once "bdd_boutique.php";
   $con = mysqli_connect("localhost", "root","", "arabe-site");

     //creer la session
 if(!isset($_SESSION['panier'])){
    //s'il nexiste pas une session on créer une et on mets un tableau a l'intérieur 
    $_SESSION['panier'] = array();
 }

   //supprimer les produits
   //si la variable del existe
   if(isset($_GET['del'])){
    $id_del = $_GET['del'] ;
    //suppression
    unset($_SESSION['panier'][$id_del]);
   }


   
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1.css">
</head>
<body>
   
    <section class="panier">
        <table>
            <tr>
                <th></th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Niveau</th>
                <th>Action</th>
                
            </tr>
            <?php 
              
              $total = 0 ;
              // liste des produits
              //récupérer les clés du tableau session
              $ids = array_keys($_SESSION['panier']);
             
              //s'il n'y a aucune clé dans le tableau
              if(empty($ids)){
                echo "Votre panier est vide";
              }else {
                //si oui 
                $products = mysqli_query($con, "SELECT * FROM products WHERE id IN (".implode(',', $ids).")");

                //lise des produit avec une boucle foreach
                foreach($products as $product):
                    //calculer le total ( prix unitaire * quantité) 
                    //et aditionner chaque résutats a chaque tour de boucle
                    $total = $total + $product['price'] * $_SESSION['panier'][$product['id']] ;
                    
                    // TABLE LEVEL_STUDENT
                    $level="SELECT * FROM level_student";
                    $list_level=mysqli_query($con,$level); //Connexion à la table leve_student de la bdd
                  
                    
                ?>
                <tr>
                    <td><img src="boutique/project_images/<?=$product['image']?>"></td>
                    <td><?=$product['name']?></td>
                    <td><?=$product['price']?>€</td>
                    <td><?=$_SESSION['panier'][$product['id']] // Quantité?></td>
                    <?php endforeach ;} ?>   
                    
                    <!-- Niveau  -->
                  
                    <td>
                        <select name="name_level" id="level_student" required>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1] ?></option>
                   <?php var_dump($row) ?>
                        </select>

                      
                    </td>
                    <td><a href="landing.php?del=<?=$product['id']?>"><img src="boutique/project_images/delete.png"></a></td>
                </tr>
                

         

            <tr class="total">
                <th>Total : <?=$total?>€</th>
            </tr>
        </table>
    </section>
</body>
</html>
