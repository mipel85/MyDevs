# Créer un item Budget dans le module Financial
## form/item/table
- `budget_id`
- `budget_name` ( date ? )
- `jpo_total_amount`
- `jpo_day_amount`
- `exam_total_amount`
- `exam_day_amount`
- `authorizations`
## Delete
## Manager
- name
- ...
- edit
- delete
## Service
- Liste des items
# Config Générale
- Ajouter un select de la liste des items Budget (formulaire + constante)
# Gestion du budget
Pour chaque item de demande (Activity et Dedicated)
- ajouter une colonne `budget` dans la table
- déclarer le `budget` dans le `init_default_properties()` dans lequel on récupère le choix de `budget_id` fait dans la config
- ajouter un FormFieldHidden `budget` dans le form (qui récupèrera automatiquement la valeur déclarée du `init_default_properties()`)
- effectuer le décompte des paiements sur le budget_id au lieu de la config