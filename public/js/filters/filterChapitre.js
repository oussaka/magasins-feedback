/**
 * Created by Oussama K on 12/09/14.
 */

'use strict';
appIndic.service("filterChapitre", [
    function() {
        this.getChapFilter = function(data) {

            var chapitres = [];
            angular.forEach(data, function(value, key){
                var chapitre = value.indicateur.chapitre;
                if ($.inArray(chapitre.id, chapitres.map(function(x) {
                    return x.id;
                })) == -1) {
                    this.push({id: chapitre.id, title: chapitre.titre});
                }
            }, chapitres);

            return chapitres;
        };
    }
]);