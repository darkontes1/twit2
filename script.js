//Quand on va cliquer sur le bouton de connexion
$(document).on("click","#co",function(){
    var valueCo = $("#valueCo").val();
    $.ajax({
        method:"POST",
        url:"index_pdo.php",
        data:{"action":"co",
            "login":valueCo,
            "javascript":"oui" 
        },
        success:function(r){
            //console.log(eval(r));
        }
    });
});

//Quand on va cliquer sur le bouton de déconnexion
$(document).on("click", "#deco", function(){
    $.ajax({
        method: "POST",
        url: "index_pdo.php",
        data:{"action":"deco",
              "javascript":"non"
            },
        success : function(r){}
    });
});
//Quand on va cliquer sur le lien pour retweet
$(document).on("click","#a_retweet", function(){
    var idTwit = $("#a_retweet").attr("data-value").value;
    $.ajax({
        method:"GET",
        url:"index_pdo.php",
        data:{"action":"retweet",
            "idTwit":idTwit
        },
        success:function(r){}
    });
});
//Quand on va cliquer sur le lien pour favori
$(document).on("click","#a_favori", function(){
    var idTwit = $("#a_favori").attr("data-value").value;
    $.ajax({
        method:"GET",
        url:"index_pdo.php",
        data:{"action":"favori",
            "idTwit":idTwit
        },
        success:function(r){}
    });
});
//Quand on va cliquer sur le bouton pour ajouter un tweet à la base
$(document).on("click","#ajout", function(){
    var ajoutval = $("#ajouttweet").val();
    $.ajax({
        method:"POST",
        url:"index_pdo.php",
        data:{"action":"ajout",
            "tweet":ajoutval
        },
        success:function(r){}
    });
});
//Quand on va cliquer sur le lien pour afficher tous les tweets
$(document).on("click","#titre", function(e){
    e.preventDefault();
    $.ajax({
        method:"GET",
        url:"json.php",
        data:{"action":"tweet"},
        success:function(r){
            //$("container").html($(r).find("container").html());
            var html = "";
            var toto = eval(r);
            //console.log(toto[1][7]['loginUser']);
            if(toto[1].length==0){
                $_SESSION['nb'] = 0;
                console.log("PAS DE TWEET DANS LA BASE !");
            }
            else{
                for(i=0;i<toto[1].length;i++){
                    if(toto[2]['login'] == toto[1][i]['loginUser']){
                        html += '<article>';
                        html += '<div id="top-article">';
                        /*/!\CREER UNE DATE EN JS FU FOR ME*/
                        html += '<p><b>'+new date('j-m-y',strtotime(toto[1][$i]['dateTwit']))+'</b>';
                        html += '<br/>'+new date('j-m-y',strtotime(toto[1][$i]['dateTwit']))+'</p>';
                        html += '</div>';
                        html += '<p>'+toto[1][$i]['messageTwit']+'...<br/>@'+toto[1][$i]['loginUser']+'</p>';
                        //IMPORTANT !!! syntaxe d'un get à la place de faire un form pour une action
                        html += '<a class="bouton-action" href="index_pdo.php" id="a_modifier" data-value="'+toto[1][$i]['idTwit']+'"">modifier</a>';
                        html += '<a class="bouton-action" href="index_pdo.php" id="a_supprimer" data-value="'+toto[1][$i]['idTwit']+'"">supprimer</a>';
                        html += '</article>';
                    }
                    else{
                        html += '<article>';
                        html += '<div id="top-article">';
                        html += '<p><b>'+new date('j-m-y',strtotime(toto[1][$i]['dateTwit']))+'</b>';
                        html += '<br/>'+new date('j-m-y',strtotime(toto[1][$i]['dateTwit']))+'</p>';
                        html += '</div>';
                        html += '<p>'+toto[1][$i]['messageTwit']+'...<br/>@'+toto[1][$i]['loginUser']+'</p>';
                        //IMPORTANT !!! syntaxe d'un get à la place de faire un form pour une action
                        html += '<a class="bouton-action" href="index_pdo.php id="a_retwit" data-value="'+toto[1][$i]['idTwit']+'">retwit</a>';
                        //Si il est favori
                        
                        if(toto[1][$i]['fav'] == 1){
                            html += '<a class="fav-orange" href="index_pdo.php id="a_favori" data-value="'+toto[1][$i]['idTwit']+'">favori</a>';
                        }
                        else{
                            html += '<a class="bouton-action" href="index_pdo.php id="a_favori" data-value="'+toto[1][$i]['idTwit']+'">favori</a>';
                        }
                        html += '</article>';
                    }                     
                }
                $("#div_change").append(html);
            }
            //console.log(eval(r));
        }
    });
});

/*$(window).load(function(){
    //e.preventDefault();
    $.ajax({
        method:"GET",
        url:"json.php",
        data:{"action":"tweet"
        },
        success:function(r){
            //$("container").html($(r).find("container").html());
            console.log(r);
        }
    });

});*/