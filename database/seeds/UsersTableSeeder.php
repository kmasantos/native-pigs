<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Farm;
use App\Models\Animal;
use App\Models\AnimalType;
use App\Models\AnimalProperty;
use App\Models\Property;
use App\Models\Breed;

class UsersTableSeeder extends Seeder
{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
				$now = Carbon::now();

				$sampleFarm = new Farm;
				$sampleFarm->name = "SampleFarm";
				$sampleFarm->code = "QUEBAIBP";
				$sampleFarm->address = "Quezon";

				$sampleUser = new User;
				$sampleUser->name = "SampleUser";
				$sampleUser->email = "laubreyual@gmail.com";

				/**********************************/
				/********* Chicken Seeder *********/
				/**********************************/

				// Individual Records Seeder (Chicken)
				$individuale1 = new Property;
				$individuale1->name = "Date Hatched";
				$individuale1->fname = "date_hatched";
				$individuale1->description = "Date when chicken/duck hatched";
				$individuale1->save();

				$individuale2 = new Property;
				$individuale2->name = "Individual ID";
				$individuale2->fname = "individual_id";
				$individuale2->description = "Individual ID derived from the wing band";
				$individuale2->save();

				$individuale3 = new Property;
				$individuale3->name = "Generation";
				$individuale3->fname = "generation";
				$individuale3->description = "Generation of the animal add";
				$individuale3->save();

				$individuale4 = new Property;
				$individuale4->name = "Line";
				$individuale4->fname = "line";
				$individuale4->description = "Line property of the animal to add";
				$individuale4->save();

				$individuale5 = new Property;
				$individuale5->name = "Family";
				$individuale5->fname = "family";
				$individuale5->description = "Family of the animal to add";
				$individuale5->save();

				$individuale6 = new Property;
				$individuale6->name = "Gender";
				$individuale6->fname = "gender";
				$individuale6->description = "Gender of the animal to add";
				$individuale6->save();

				$individuale7 = new Property;
				$individuale7->name = "Date Transferred";
				$individuale7->fname = "date_transferred";
				$individuale7->description = "Date when the animal was transferred to the replacement stocks";
				$individuale7->save();

				$this->command->info('Chicken individual properties seeded');

				// Phenotypic Characteristics Seeder (Chicken)
				$pheno1 = new Property;
				$pheno1->name = "Plummage Color";
				$pheno1->fname = "plummage_color";
				$pheno1->description = "Plummage color of the chicken";
				$pheno1->save();

				$pheno2 = new Property;
				$pheno2->name = "Plummage Pattern";
				$pheno2->fname = "plummage_pattern";
				$pheno2->description = "Plummage pattern of the chicken";
				$pheno2->save();

				$pheno3 = new Property;
				$pheno3->name = "Body Carriage";
				$pheno3->fname = "body_carriage";
				$pheno3->description = "Body carriage of the chicken";
				$pheno3->save();

				$pheno4 = new Property;
				$pheno4->name = "Comb Type";
				$pheno4->fname = "comb_type";
				$pheno4->description = "Comb type of the chicken";
				$pheno4->save();

				$pheno5 = new Property;
				$pheno5->name = "Comb Color";
				$pheno5->fname = "comb_color";
				$pheno5->description = "Comb color of the chicken";
				$pheno5->save();

				$pheno6 = new Property;
				$pheno6->name = "Earlobe Color";
				$pheno6->fname = "earlobe_color";
				$pheno6->description = "Earlobe color of the chicken";
				$pheno6->save();

				$pheno7 = new Property;
				$pheno7->name = "Shank Color";
				$pheno7->fname = "shank_color";
				$pheno7->description = "Shank color of the chicken";
				$pheno7->save();

				$pheno8 = new Property;
				$pheno8->name = "Skin Color";
				$pheno8->fname = "skin_color";
				$pheno8->description = "Skin color of the chicken";
				$pheno8->save();

				$pheno9 = new Property;
				$pheno9->name = "Iris Color";
				$pheno9->fname = "iris_color";
				$pheno9->description = "Iris color of the chicken";
				$pheno9->save();

				$pheno10 = new Property;
				$pheno10->name = "Beak Color";
				$pheno10->fname = "beak_color";
				$pheno10->description = "Beak color of the chicken";
				$pheno10->save();

				$pheno11 = new Property;
				$pheno11->name = "Other Unique Features";
				$pheno11->fname = "other_features";
				$pheno11->description = "Other noticeable features of the chicken";
				$pheno11->save();

				$this->command->info('Chicken phenotypic properties seeded');

				// Morphometric Characteristics
				$morpho1 = new Property;
				$morpho1->name = "height";
				$morpho1->fname = "height";
				$morpho1->description = "Height of the chicken";
				$morpho1->save();

				$morpho2 = new Property;
				$morpho2->name = "Body Lenght";
				$morpho2->fname = "body_lenght";
				$morpho2->description = "Body lenght of the chicken";
				$morpho2->save();

				$morpho3 = new Property;
				$morpho3->name = "Chest Circumference";
				$morpho3->fname = "chest_circumference";
				$morpho3->description = "Chest circumference of the chicken";
				$morpho3->save();

				$morpho4 = new Property;
				$morpho4->name = "Wing Span";
				$morpho4->fname = "wing_span";
				$morpho4->description = "Wing span of the chicken";
				$morpho4->save();

				$morpho5 = new Property;
				$morpho5->name = "Shank Lenghth";
				$morpho5->fname = "shank_length";
				$morpho5->description = "Shank length of the chicken";
				$morpho5->save();

				$morpho6 = new Property;
				$morpho6->name = "Date at First Lay";
				$morpho6->fname = "date_first_lay";
				$morpho6->description = "Date when the chicken first layed it's eggs";
				$morpho6->save();

				$this->command->info('Chicken morphometric properties seeded');


				/**********************************/
				/********** Duck Seeder ***********/
				/**********************************/

				/**********************************/
				/*********** Pig Seeder ***********/
				/**********************************/

				$individual1 = new Property;
				$individual1->name = "Date Farrowed";
				$individual1->fname = "date_farrowed";
				$individual1->description = "Date when pigs were born";
				$individual1->save();

				$individual2 = new Property;
				$individual2->name = "Registration ID";
				$individual2->fname = "registration_id";
				$individual2->description = "Registration ID of the pig";
				$individual2->save();

				$individual3 = new Property;
				$individual3->name = "Sex";
				$individual3->fname = "sex";
				$individual3->description = "Sex of the pig";
				$individual3->save();

				$this->command->info('Pig individual properties seeded');

				//Gross Morphology
				$gross1 = new Property;
				$gross1->name = "Hair Type 1";
				$gross1->fname = "hair_type1";
				$gross1->description = "Hair type of the pig";
				$gross1->save();

				$gross2 = new Property;
				$gross2->name = "Hair Type 2";
				$gross2->fname = "hair_type2";
				$gross2->description = "Hair type of the pig";
				$gross2->save();

				$gross3 = new Property;
				$gross3->name = "Coat Color";
				$gross3->fname = "coat_color";
				$gross3->description = "Coat color of the pig";
				$gross3->save();

				$gross4 = new Property;
				$gross4->name = "Color Pattern";
				$gross4->fname = "color_pattern";
				$gross4->description = "Color pattern of the pig";
				$gross4->save();

				$gross5 = new Property;
				$gross5->name = "Head Shape";
				$gross5->fname = "head_shape";
				$gross5->description = "Head shape of the pig";
				$gross5->save();

				$gross6 = new Property;
				$gross6->name = "Skin Type";
				$gross6->fname = "skin_type";
				$gross6->description = "Skin type of the pig";
				$gross6->save();

				$gross7 = new Property;
				$gross7->name = "Ear Type";
				$gross7->fname = "ear_type";
				$gross7->description = "Ear type of the pig";
				$gross7->save();

				$gross8 = new Property;
				$gross8->name = "Backline";
				$gross8->fname = "backline";
				$gross8->description = "Backline of the pig";
				$gross8->save();

				$gross9 = new Property;
				$gross9->name = "Other Marks";
				$gross9->fname = "other_marks";
				$gross9->description = "Other marks of the pig";
				$gross9->save();

				$this->command->info('Pig gross morphology properties seeded');

				//morphometric characteristics
				$morpho7 = new Property;
				$morpho7->name = "Age at First Mating";
				$morpho7->fname = "age_at_first_mating";
				$morpho7->description = "Age of the pig during its first mating";
				$morpho7->save();

				$morpho8 = new Property;
				$morpho8->name = "Final Weight at 8 Months";
				$morpho8->fname = "final_weight_at_8_months";
				$morpho8->description = "Final weight of the pig at 8 months";
				$morpho8->save();

				$morpho9 = new Property;
				$morpho9->name = "Head Length";
				$morpho9->fname = "head_length";
				$morpho9->description = "Head length of the pig";
				$morpho9->save();

				$morpho10 = new Property;
				$morpho10->name = "Body Length";
				$morpho10->fname = "body_length";
				$morpho10->description = "Body length of the pig";
				$morpho10->save();

				$morpho11 = new Property;
				$morpho11->name = "Pelvic Width";
				$morpho11->fname = "pelvic_width";
				$morpho11->description = "Pelvic width of the pig";
				$morpho11->save();

				$morpho12 = new Property;
				$morpho12->name = "Heart Girth";
				$morpho12->fname = "heart_girth";
				$morpho12->description = "Heart girth of the pig";
				$morpho12->save();

				$morpho13 = new Property;
				$morpho13->name = "Ponderal Index";
				$morpho13->fname = "ponderal_index";
				$morpho13->description = "Ponderal index of the pig";
				$morpho13->save();

				$morpho14 = new Property;
				$morpho14->name = "Number of Normal Teats";
				$morpho14->fname = "number_of_normal_teats";
				$morpho14->description = "Number of normal teats for the pig";
				$morpho14->save();

				$this->command->info('Pig morphometric properties seeded');

				//body weights
				$weight1 = new Property;
				$weight1->name = "Body Weight at 45 Days";
				$weight1->fname = "body_weight_at_45_days";
				$weight1->description = "Body weight of the pig at 45 days";
				$weight1->save();

				$weight2 = new Property;
				$weight2->name = "Body Weight at 60 Days";
				$weight2->fname = "body_weight_at_60_days";
				$weight2->description = "Body weight of the pig at 60 days";
				$weight2->save();

				$weight3 = new Property;
				$weight3->name = "Body Weight at 180 Days";
				$weight3->fname = "body_weight_at_180_days";
				$weight3->description = "Body weight of the pig at 180 days";
				$weight3->save();

				$this->command->info('Pig body weight properties seeded');

				$mating1 = new Property;
				$mating1->name = "Date Bred";
				$mating1->fname = "date_bred";
				$mating1->description = "Date when the sow and boar was bred";
				$mating1->save();

				$mating2 = new Property;
				$mating2->name = "Expected Date of Farrowing";
				$mating2->fname = "expected_date_of_farrowing";
				$mating2->description = "Expected date of farrowing";
				$mating2->save();

				$mating3 = new Property;
				$mating3->name = "Date Pregnant";
				$mating3->fname = "date_pregnant";
				$mating3->description = "Date when sow became pregnant";
				$mating3->save();

				$this->command->info('Pig mating properties seeded');

				$sowlitter1 = new Property;
				$sowlitter1->name = "Remarks";
				$sowlitter1->fname = "litter_remarks";
				$sowlitter1->description = "Remarks about the offspring";
				$sowlitter1->save();

				$sowlitter2 = new Property;
				$sowlitter2->name = "Birth Weight";
				$sowlitter2->fname = "birth_weight";
				$sowlitter2->description = "Birth weight of offspring";
				$sowlitter2->save();

				$sowlitter3 = new Property;
				$sowlitter3->name = "Weaning weight";
				$sowlitter3->fname = "weaning_weight";
				$sowlitter3->description = "Weaning weight of offspring";
				$sowlitter3->save();

				$this->command->info('Pig sow-litter properties seeded');

				$mortality = new Property;
				$mortality->name = "Date Died";
				$mortality->fname = "date_died";
				$mortality->description = "Date when pig died";
				$mortality->save();

				$sales1 = new Property;
				$sales1->name = "Date Sold";
				$sales1->fname = "date_sold";
				$sales1->description = "Date when pig was sold";
				$sales1->save();

				$sales2 = new Property;
				$sales2->name = "Weight Sold";
				$sales2->fname = "weight_sold";
				$sales2->description = "Weight of pig when it was sold";
				$sales2->save();

				$this->command->info('Pig mortality and sales properties seeded');

				$this->command->info('Properties value seeded');

				$duck = new AnimalType;
				$chicken = new AnimalType;
				$pig = new AnimalType;
				$duck->species = "duck";
				$chicken->species = "chicken";
				$pig->species = "pig";
				$chicken->save();
				$duck->save();
				$pig->save();
				$this->command->info('Animaltypes seeded');

				$quezon = new Breed;
				$quezon->breed = "BAI";
				$quezon->animaltype_id = $pig->id;
				$quezon->save();
				$bohol = new Breed;
				$bohol->breed = "BOHOL";
				$bohol->animaltype_id = $chicken->id;
				$bohol->save();
				$this->command->info('Breed seeded');

				$sampleFarm->breedable_id = $quezon->id;
				$sampleFarm->save();

				$sampleFarm->users()->save($sampleUser);
				$this->command->info('User seeded');

				$animal = new Animal;
				$sampleFarm->animaltypes()->attach($chicken->id);
				$animal->animaltype_id = $chicken->id;
				$animal->farm_id = $sampleFarm->id;
				$animal->breed_id = $bohol->id;
				$animal->status = "replacement";
				$animal->save();
				$this->command->info('Animal seeded');

				$animal2 = new Animal;
				$sampleFarm->animaltypes()->attach($pig->id);
				$animal2->animaltype_id = $pig->id;
				$animal2->farm_id = $sampleFarm->id;
				$animal2->breed_id = $quezon->id;
				$animal2->status = "breeder";
				$animal2->save();
				$this->command->info('Animal seeded');

				$animal3 = new Animal;
				$sampleFarm->animaltypes()->attach($pig->id);
				$animal3->animaltype_id = $pig->id;
				$animal3->farm_id = $sampleFarm->id;
				$animal3->breed_id = $quezon->id;
				$animal3->status = "breeder";
				$animal3->save();
				$this->command->info('Animal seeded');

				$animal4 = new Animal;
				$sampleFarm->animaltypes()->attach($pig->id);
				$animal4->animaltype_id = $pig->id;
				$animal4->farm_id = $sampleFarm->id;
				$animal4->breed_id = $quezon->id;
				$animal4->status = "breeder";
				$animal4->save();
				$this->command->info('Animal seeded');

				$animalproperty1 = new AnimalProperty;
				$animalproperty1->animal_id = $animal->id;
				$animalproperty1->property_id = $individuale1->id;
				$date = new Carbon();
				$animalproperty1->value = $date->subMonths(2)->toDateString();
				$animalproperty1->save();

				$animalproperty2 = new AnimalProperty;
				$animalproperty2->animal_id = $animal->id;
				$animalproperty2->property_id = $individuale2->id;
				$animalproperty2->value = $sampleFarm->code.'-'.$now->year.'F1233';
				$animalproperty2->save();

				$animalproperty3 = new AnimalProperty;
				$animalproperty3->animal_id = $animal->id;
				$animalproperty3->property_id = $individuale3->id;
				$animalproperty3->value = "A";
				$animalproperty3->save();

				$animalproperty4 = new AnimalProperty;
				$animalproperty4->animal_id = $animal->id;
				$animalproperty4->property_id = $individuale4->id;
				$animalproperty4->value = "C";
				$animalproperty4->save();

				$animalproperty5 = new AnimalProperty;
				$animalproperty5->animal_id = $animal->id;
				$animalproperty5->property_id = $individuale5->id;
				$animalproperty5->value = "B";
				$animalproperty5->save();

				$animalproperty6 = new AnimalProperty;
				$animalproperty6->animal_id = $animal->id;
				$animalproperty6->property_id = $individuale6->id;
				$animalproperty6->value = "F";
				$animalproperty6->save();

				$animalproperty7 = new AnimalProperty;
				$animalproperty7->animal_id = $animal->id;
				$animalproperty7->property_id = $individuale7->id;
				$animalproperty7->value = $now->toDateString();
				$animalproperty7->save();
				$this->command->info('AnimalProperty seeded');


				$animal->registryid = $animalproperty2->value ;
				$animal->save();
				$this->command->info('Registry ID added to animal');

				/**********************************/
				/**** Swine Seeder ****/
				/**********************************/
				$animalproperty8 = new AnimalProperty;
				$animalproperty8->animal_id = $animal2->id;
				$animalproperty8->property_id = $individual1->id;
				$date2 = new Carbon();
				$animalproperty8->value = $date2->subMonths(2)->toDateString();
				$animalproperty8->save();

				$animalproperty9 = new AnimalProperty;
				$animalproperty9->animal_id = $animal2->id;
				$animalproperty9->property_id = $individual3->id;
				$animalproperty9->value = "F";
				$animalproperty9->save();

				$animalproperty10 = new AnimalProperty;
				$animalproperty10->animal_id = $animal2->id;
				$animalproperty10->property_id = $individual2->id;
				$animalproperty10->value = $sampleFarm->code.'-'.$now->year.$animalproperty9->value.'1000';
				$animalproperty10->save();
				$this->command->info('AnimalProperty seeded');

				$animal2->registryid = $animalproperty10->value;
				$animal2->save();
				$this->command->info('Registry ID added to animal');

				$animalproperty11 = new AnimalProperty;
				$animalproperty11->animal_id = $animal3->id;
				$animalproperty11->property_id = $individual1->id;
				$date3 = new Carbon();
				$animalproperty11->value = $date3->subMonths(2)->toDateString();
				$animalproperty11->save();

				$animalproperty12 = new AnimalProperty;
				$animalproperty12->animal_id = $animal3->id;
				$animalproperty12->property_id = $individual3->id;
				$animalproperty12->value = "M";
				$animalproperty12->save();

				$animalproperty13 = new AnimalProperty;
				$animalproperty13->animal_id = $animal3->id;
				$animalproperty13->property_id = $individual2->id;
				$animalproperty13->value = $sampleFarm->code.'-'.$now->year.$animalproperty12->value.'2000';
				$animalproperty13->save();
				$this->command->info('AnimalProperty seeded');

				$animal3->registryid = $animalproperty13->value;
				$animal3->save();
				$this->command->info('Registry ID added to animal');

				$animalproperty14 = new AnimalProperty;
				$animalproperty14->animal_id = $animal4->id;
				$animalproperty14->property_id = $individual1->id;
				$date3 = new Carbon();
				$animalproperty14->value = $date3->subMonths(2)->toDateString();
				$animalproperty14->save();

				$animalproperty15 = new AnimalProperty;
				$animalproperty15->animal_id = $animal4->id;
				$animalproperty15->property_id = $individual3->id;
				$animalproperty15->value = "F";
				$animalproperty15->save();

				$animalproperty16 = new AnimalProperty;
				$animalproperty16->animal_id = $animal4->id;
				$animalproperty16->property_id = $individual2->id;
				$animalproperty16->value = $sampleFarm->code.'-'.$now->year.$animalproperty12->value.'1001';
				$animalproperty16->save();
				$this->command->info('AnimalProperty seeded');

				$animal4->registryid = $animalproperty16->value;
				$animal4->save();
				$this->command->info('Registry ID added to animal');
		}
	
}
