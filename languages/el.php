<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

return [

    'egallery' => 'Attach photos on Elgg Entities',
    'entity_gallery' => 'Άλμπουμ',
    'collection:object:entity_gallery' => 'Άλμπουμ φωτογραφιών',
    'collection:object:gallery_item' => 'Φωτογραφίες',
    'item:object:entity_gallery' => 'Άλμπουμ φωτογραφιών',
    'item:object:gallery_item' => 'Φωτογραφίες',
    'collection:object:about' => 'Σχετικά',// missing from Elgg
    'entity_gallery:none' => 'Δεν υπάρχουν Άλμπουμ',
    'collection:object:entity_gallery:owner' => '%s\'s Galleries',
    'collection:object:entity_gallery:mine' => 'Τα Άλμπουμ μου',
    'collection:object:entity_gallery:friends' => 'Άλμπουμ φίλων',
    'collection:object:entity_gallery:all' => 'Άλμπουμ φωτογραφιών',
    'entity_gallery:menu' => 'Φωτογραφίες',

    // gallery form
    'egallery:add:gallery' => "Προσθήκη",
    'egallery:add:requiredfields' => 'Τα πεδία με αστερίσκο (*) είναι υποχρεωτικά',
    'egallery:add:title' => "Τίτλος",
    'egallery:add:title:help' => "Εισάγετε τίτλο του άλμπουμ",
    'egallery:add:value' => "Ανήκει στο: '%s'",
    'egallery:add:value:user' => "Άλμπουμ χρήστη %s",
    'egallery:add:description' => "Περιγραφή",
    'egallery:add:description:help' => "Εισάγετε περιγραφή του άλμπουμ",
    'egallery:add:tags' => "Ετικέτες",
    'egallery:add:tags:help' => "Εισάγετε μερικές ετικέτες",
    'egallery:add:submit' => "Υποβολή",       
    'egallery:save:missing_title' => "Δεν ορίσατε τίτλο, αδύνατη η αποθήκευση.",
    'egallery:save:success' => "Το άλμπουμ αποθηκεύτηκε επιτυχώς", 
    'egallery:save:failed' => "Το άλμπουμ δεν μπορεί να αποθηκευτεί", 
    'egallery:set_cover:success' => "Το εξώφυλλο άλλαξε επιτυχώς", 
    'egallery:set_cover:failed' => "Αδύνατη η αποθήκευση του εξώφυλλου", 
    'egallery:item:add:title' => "Τίτλος",
    'egallery:item:add:title:help' => "Εισάγετε μία λεζάντα για τη φωτογραφία",
    'egallery:item:add:url' => "Πηγή φωτογραφίας (url)",
    'egallery:item:add:url:help' => "Προαιρετικά εισάγετε ένα URL για την πηγή της φωτογραφίας",
    'egallery:item:add:description' => "Περιγραφή",
    'egallery:item:add:description:help' => "Προαιρετικά εισάγετε περιγραφή της φωτογραφίας",
    'egallery:import:tidypics' => 'Εισαγωγή από tidypics',
    'egallery:import:tidypics:album' => 'Επιλογή άλμπουμ',
    'egallery:import:tidypics:album:note' => 'Επιλογή άλμπουμ για εισαγωγή στο %s',
    'egallery:import:tidypics:success' => '%s φωτογραφίες αποθηκεύτηκαν επιτυχώς',
    'egallery:import:tidypics:fail' => 'Η εισαγωγή απέτυχε, το άλμπουμ είναι κενό',
    'egallery:import:tidypics:error' => 'Η εισαγωγή φωτογραφίων δεν είναι ενεργοποιημένη ή το Tidypics plugin δεν είναι ενεργό',
    'egallery:import:tidypics:egallery:invalid' => 'Μη έγκυρο άλμπουμ',
    'egallery:import:tidypics:egallery:invalid_access' => 'Μη έγκυρη πρόσβαση',
    'egallery:import:tidypics:album:invalid' => 'Μη έγκυρο άλμπουμ Tidypics',
    'egallery:import:tidypics:album:invalid_access' => 'Δεν έχετε δικαιώματα εισαγωγής από αυτό το άλμπουμ',

    // gallery item
    'egallery:item:comment' => "Προβολή και σχόλια",
    'egallery:item:download' => "Λήψη", 
    'egallery:item:default_title' => 'Επεξεργασία φωτογραφίας',
    'egallery:item:edit' => 'Επεξεργασία φωτογραφίας',
    'egallery:item:set_cover' => 'Ορισμός ως εξώφυλλο άλμπουμ',
    'egallery:item:save:missing_title' => "Δεν ορίσατε τίτλο, αδύνατη η αποθήκευση.",
    'egallery:item:save:url_error' => "Το URL δεν είναι έγκυρο, αδύνατη η αποθήκευση.",
    'egallery:item:url' => "Πηγή φωτογραφίας", 
    
    // status messages
    'egallery:invalid' => 'Μη έγκυρη εγγραφή ή μη έγκυρη πρόσβαση',
    'egallery:invalid_access' => "Μη έγκυρη πρόσβαση",
    'egallery:onject:disabled' => "Δεν είναι ενεργοποιημένη η προσθήκη άλμπουμ για αυτόν τον τύπο δεδομένων: %s",
    'egallery:item:delete:success' => "Η φωτογραφία διαγράφτηκε επιτυχώς", 
    'egallery:item:delete:failed' => "Η φωτογραφία δεν μπορεί να διαγραφτεί",
    'egallery:item:save:success' => "Η φωτογραφία αποθηκεύτηκε επιτυχώς", 
    'egallery:item:save:failed' => "Η φωτογραφία δεν μπορεί να αποθηκευτεί", 
    'egallery:invalid_item' => "Μη έγκυρη εγγραφή",
    'egallery:invalid_gallery' => "Μη έγκυρο άλμπουμ",
    'egallery:set_cover:success' => "Το εξώφυλλο αποθηκεύτηκε επιτυχώς", 
    'egallery:set_cover:failed' => "Το εξώφυλλο δεν μπορεί να αποθηκευτεί", 
    'egallery:delete:success' => "Το άλμπουμ διαγράφτηκε επιτυχώς", 
    'egallery:delete:failed' => "Το άλμπουμ δεν μπορεί να διαγραφεί",

    // widgets
    'egallery:galleries:more' => 'Περισσότερα Άλμπουμ',
    'egallery:numbertodisplay' => 'Αριθμός Άλμπουμ για εμφάνιση',
    'widgets:entity_gallery:description' => "Εμφάνιση άλμπουμ φωτογραφίων",

    // river
	'river:object:entity_gallery:create' => '%s δημιούργησε το άλμπουμ %s',
    'river:object:entity_gallery:container' => 'Άλμπουμ  %s - ',
	'river:object:entity_gallery:comment' => '%s σχολίασε στο άλμπουμ%s',

    // groups
    'collection:object:entity_gallery:group' => 'Άλμπουμ ομάδας',
    'groups:tool:entity_gallery' => 'Ενεργοποίηση άλμπουμ ομάδας',
    'egallery:owner' => "%s's galleries",
    'egallery:add:gallery:groups' => "Προσθήκη άλμπουμ",
        
];

