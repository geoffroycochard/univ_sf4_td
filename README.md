# TD SF4 // 2018

1. Cloner et installer le dépôt suivant : https://github.com/geoffroycochard/univ_sf4_td.git
2. Charger des fixtures : `bin/console doctrine:fixtures:load`
3. Créer dans le menu une entrée "Ticket" renvoyant sur la route "ticket_crud_index" 
4. Je veux obtenir la liste des utilisateurs dans un tableau affichant :
    * name
    * email
    * nombre de tickets assignés
    * action voir le détail
5. Créer une vue détail de l'utilisateur en affichant les tickets qui lui sont assignés
6. Automatiser un compteur qui permet d'avoir le nombre de ticket assigné à un user