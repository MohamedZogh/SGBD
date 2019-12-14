<?php
if ($_SESSION["role"]== "User" || $_SESSION["role"]== "Admin") {
    echo'
        <!-- Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Panier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="index.php">
                            <table class="table table-dark" style="width: 400px">
                                <tbody>
                                <tr>
                                    <td colspan="4">Votre panier</td>
                                </tr>
                                <tr>
                                    <td>Libellé</td>
                                    <td>Quantité</td>
                                    <td>Prix U</td>
                                    <td>Action</td>
                                </tr>';
    if (creationPanier())
    {
        $nbArticles=count($_SESSION['panier']['libelleProduit']);
        if ($nbArticles <= 0)
        {
            echo "<tr><td>Votre panier est vide </td></tr>";
        }
        else
        {
            for ($i=0 ;$i < $nbArticles ; $i++)
            {
                $text=file_get_contents("facture.html");
                $dataProduct='<tr>
                                                      <td>'.htmlspecialchars($_SESSION["panier"]["libelleProduit"][$i]).'</td>
                                                      <td><input type="number" size="4" name="q[]" value="'.htmlspecialchars($_SESSION["panier"]["qteProduit"][$i]).'"/></td>
                                                      <td>'.htmlspecialchars($_SESSION["panier"]["prixProduit"][$i]).'"</td>
                                                      <td><a href="'.htmlspecialchars("index.php?action=suppression&l=".rawurlencode($_SESSION["panier"]["libelleProduit"][$i])).'">Suppr.</a></td>
                                                  </tr>';
                $dataProductFacture='<tr>
                                                                    <td>'.$_SESSION["panier"]["libelleProduit"][$i].'</td>
                                                                    <td><span style="color: blue">'.$_SESSION["panier"]["qteProduit"][$i].'</span></td>
                                                                    <td style="color: lawngreen">'.$_SESSION["panier"]["prixProduit"][$i].'</td>
                                                                 </tr>';
                echo $dataProduct;
                file_put_contents("facture.html", $text.$dataProductFacture);
            }
            echo '<tr>
                                                <td colspan="2"> </td>
                                                <td colspan="2">
                                                Total : '.MontantGlobal().'
                                                </td>
                                              </tr>
                                            <tr>    
                                                <td colspan="4">
                                                <input type="submit" value="Modifier"/>
                                                <button type="submit"><a href="facture.html" download>Acheter</button>
                                                <input type="hidden" name="action" value="refresh"/>
                                                </td>
                                            </tr>';
            $footFacture='<tr>
                                                        <td colspan="2"> </td>
                                                        <td colspan="2" style="color: red">
                                                        Total : '.MontantGlobal().'
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                      </tr>';
            $text=file_get_contents("facture.html");
            file_put_contents("facture.html", $text.$footFacture);
        }
    }
    $text=file_get_contents("facture.html");
    $endFacture='</tbody>
                                            </table>
                                        </div>
                                    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                                </body>
                            </html>
                                                ';
    file_put_contents("facture.html", $text.$endFacture);
    ?>
    </tbody>
    </table>
    </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </div>
    </div>
    </div>';
    <?php
}
