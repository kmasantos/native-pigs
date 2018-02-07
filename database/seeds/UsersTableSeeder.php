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
use App\Models\Grouping;
use App\Models\GroupingMember;
use App\Models\GroupingProperty;


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

				$msc = new Farm;
				$msc->name = "Marinduque State College";
				$msc->code = "MARMSC";
				$msc->address = "Marinduque";

				$mscUser = new User;
				$mscUser->name = "MSC";
				$mscUser->email = "marindukepig@gmail.com";

				$group = new Grouping;

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
				$mating3->name = "Status";
				$mating3->fname = "mating_status";
				$mating3->description = "Status of pig after mating";
				$mating3->save();

				$mating4 = new Property;
				$mating4->name = "Recycled";
				$mating4->fname = "recycled";
				$mating4->description = "Whether the sow is recycled or not";
				$mating4->save();

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

				$dc1 = new Property;
				$dc1->name = "Date Collected at 45 Days";
				$dc1->fname = "date_collected_45_days";
				$dc1->description = "Date when body weight at 45 days was collected";
				$dc1->save();

				$dc2 = new Property;
				$dc2->name = "Date Collected at 60 Days";
				$dc2->fname = "date_collected_60_days";
				$dc2->description = "Date when body weight at 60 days was collected";
				$dc2->save();

				$dc3 = new Property;
				$dc3->name = "Date Collected at 180 Days";
				$dc3->fname = "date_collected_180_days";
				$dc3->description = "Date when body weight at 180 days was collected";
				$dc3->save();

				$this->command->info('Pig body weight properties seeded');

				$slr1 = new Property;
				$slr1->name = "Date Weaned";
				$slr1->fname = "date_weaned";
				$slr1->description = "Date when pig was weaned";
				$slr1->save();

				$this->command->info('Pig sow-litter record properties seeded');

				$gross10 = new Property;
				$gross10->name = "Tail Type";
				$gross10->fname = "tail_type";
				$gross10->description = "Tail type of the pig";
				$gross10->save();

				$morpho15 = new Property;
				$morpho15->name = "Snout Length";
				$morpho15->fname = "snout_length";
				$morpho15->description = "Snout length of the pig";
				$morpho15->save();

				$morpho16 = new Property;
				$morpho16->name = "Ear Length";
				$morpho16->fname = "ear_length";
				$morpho16->description = "Ear length of the pig";
				$morpho16->save();

				$morpho17 = new Property;
				$morpho17->name = "Tail Length";
				$morpho17->fname = "tail_length";
				$morpho17->description = "Tail length of the pig";
				$morpho17->save();

				$morpho18 = new Property;
				$morpho18->name = "Height at Withers";
				$morpho18->fname = "height_at_withers";
				$morpho18->description = "Height at withers of pig";
				$morpho18->save();

				$gross11 = new Property;
				$gross11->name = "Date Collected for Gross Morphology";
				$gross11->fname = "date_collected_gross";
				$gross11->description = "Date when gross morphology was collected";
				$gross11->save();

				$morpho19 = new Property;
				$morpho19->name = "Date Collectedd for Morphometric Characteristics";
				$morpho19->fname = "date_collected_morpho";
				$morpho19->description = "Date when morphometric characteristics was collected";
				$morpho19->save();		

				$weight4 = new Property;
				$weight4->name = "Body Weight at 90 Days";
				$weight4->fname = "body_weight_at_90_days";
				$weight4->description = "Body weight of the pig at 90 days";
				$weight4->save();		

				$dc4 = new Property;
				$dc4->name = "Date Collected at 90 Days";
				$dc4->fname = "date_collected_90_days";
				$dc4->description = "Date when body weight at 90 days was collected";
				$dc4->save();

				$this->command->info('Additional properties seeded');

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

				$marinduke = new Breed;
				$marinduke->breed = "Marinduke";
				$marinduke->animaltype_id = $pig->id;
				$marinduke->save();

				$bohol = new Breed;
				$bohol->breed = "BOHOL";
				$bohol->animaltype_id = $chicken->id;
				$bohol->save();
				$this->command->info('Breed seeded');

				$msc->breedable_id = $marinduke->id;
				$msc->save();

				$msc->users()->save($mscUser);
				$this->command->info('User seeded');

				$animal = new Animal;
				$msc->animaltypes()->attach($chicken->id);
				$animal->animaltype_id = $chicken->id;
				$animal->farm_id = $msc->id;
				$animal->breed_id = $bohol->id;
				$animal->status = "replacement";
				$animal->save();

				$animalbreeder = new Animal;
				$animalbreeder->animaltype_id = $chicken->id;
        $animalbreeder->farm_id = $msc->id;
        $animalbreeder->breed_id = $bohol->id;
        $animalbreeder->status = "breeder";
        $animalbreeder->save();

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
				$animalproperty2->value = $msc->code.'-'.$now->year.'F1233';
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

				$animal->registryid = $animalproperty2->value ;
				$animal->save();
				$this->command->info('Registry ID added to animal');

				$breederproperty1 = new AnimalProperty;
        $breederproperty1->animal_id = $animalbreeder->id;
        $breederproperty1->property_id = $individuale1->id;
        $date2 = new Carbon();
        $breederproperty1->value = $date2->subMonths(1)->toDateString();
        $breederproperty1->save();

        $breederproperty2 = new AnimalProperty;
        $breederproperty2->animal_id = $animalbreeder->id;
        $breederproperty2->property_id = $individuale2->id;
        $breederproperty2->value = "33";
        $breederproperty2->save();

        $breederproperty3 = new AnimalProperty;
        $breederproperty3->animal_id = $animalbreeder->id;
        $breederproperty3->property_id = $individuale3->id;
        $breederproperty3->value = "C";
        $breederproperty3->save();

        $breederproperty4 = new AnimalProperty;
        $breederproperty4->animal_id = $animalbreeder->id;
        $breederproperty4->property_id = $individuale4->id;
        $breederproperty4->value = "D";
        $breederproperty4->save();

        $breederproperty5 = new AnimalProperty;
        $breederproperty5->animal_id = $animalbreeder->id;
        $breederproperty5->property_id = $individuale5->id;
        $breederproperty5->value = "D";
        $breederproperty5->save();

        $breederproperty6 = new AnimalProperty;
        $breederproperty6->animal_id = $animalbreeder->id;
        $breederproperty6->property_id = $individuale6->id;
        $breederproperty6->value = "M";
        $breederproperty6->save();

        $breederproperty7 = new AnimalProperty;
        $breederproperty7->animal_id = $animalbreeder->id;
        $breederproperty7->property_id = $individuale7->id;
        $breederproperty7->value = $now->toDateString();
        $breederproperty7->save();

				$this->command->info('AnimalProperty seeded');
        
        $year = $date->subMonths(2)->year;
        $year2 = $date2->subMonths(1)->year;
        $animal->registryid = $msc->code."-".$year.$animalproperty3->value.$animalproperty4->value.$animalproperty5->value.$animalproperty6->value.$animalproperty2->value;
        $animal->save();
        $animalbreeder->registryid = $msc->code."-".$year.$breederproperty3->value.$breederproperty4->value.$breederproperty5->value.$breederproperty6->value.$breederproperty2->value;
        $animalbreeder->save();
        $this->command->info('Registry ID added to animal');

        // Seeding a group
        $group->registryid = $animalbreeder->registryid;
        $group->father_id = $animalbreeder->id;
        $group->save();
        $this->command->info('Group Seeded');

        // Seeding a group member
        $breedermember = new GroupingMember;
        $breedermember->grouping_id = $group->id;
        $breedermember->animal_id = $animalbreeder->id;
        $breedermember->save();
        $this->command->info('Breeder added to Group');
      

				/**********************************/
        /********** Duck Seeder ***********/
        /**********************************/

				/**********************************/
				/**** Swine Seeder ****/
				/**********************************/

				/* MARINDUQUE DATA SEEDERS */
				$sow1 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow1->animaltype_id = $pig->id;
				$sow1->farm_id = $msc->id;
				$sow1->breed_id = $marinduke->id;
				$sow1->status = "breeder";
				$sow1->save();
				$this->command->info('Animal seeded');

				$birthday1 = new AnimalProperty;
				$birthday1->animal_id = $sow1->id;
				$birthday1->property_id = $individual1->id;
				$date7 = new Carbon();
				$birthday1->value = $date7->subMonths(2)->toDateString();
				$birthday1->save();

				$sex1 = new AnimalProperty;
				$sex1->animal_id = $sow1->id;
				$sex1->property_id = $individual3->id;
				$sex1->value = "F";
				$sex1->save();

				$registrationid1 = new AnimalProperty;
				$registrationid1->animal_id = $sow1->id;
				$registrationid1->property_id = $individual2->id;
				$registrationid1->value = $msc->code.$marinduke->breed.'-'.$sex1->value.'001-2';
				$registrationid1->save();
				$this->command->info('AnimalProperty seeded');

				$sow1->registryid = $registrationid1->value;
				$sow1->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow2 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow2->animaltype_id = $pig->id;
				$sow2->farm_id = $msc->id;
				$sow2->breed_id = $marinduke->id;
				$sow2->status = "breeder";
				$sow2->save();
				$this->command->info('Animal seeded');

				$birthday2 = new AnimalProperty;
				$birthday2->animal_id = $sow2->id;
				$birthday2->property_id = $individual1->id;
				$date8 = new Carbon();
				$birthday2->value = $date8->subMonths(2)->toDateString();
				$birthday2->save();

				$sex2 = new AnimalProperty;
				$sex2->animal_id = $sow2->id;
				$sex2->property_id = $individual3->id;
				$sex2->value = "F";
				$sex2->save();

				$registrationid2 = new AnimalProperty;
				$registrationid2->animal_id = $sow2->id;
				$registrationid2->property_id = $individual2->id;
				$registrationid2->value = $msc->code.$marinduke->breed.'-'.$sex2->value.'01-10';
				$registrationid2->save();
				$this->command->info('AnimalProperty seeded');

				$sow2->registryid = $registrationid2->value;
				$sow2->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow3 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow3->animaltype_id = $pig->id;
				$sow3->farm_id = $msc->id;
				$sow3->breed_id = $marinduke->id;
				$sow3->status = "breeder";
				$sow3->save();
				$this->command->info('Animal seeded');

				$birthday3 = new AnimalProperty;
				$birthday3->animal_id = $sow3->id;
				$birthday3->property_id = $individual1->id;
				$date9 = new Carbon();
				$birthday3->value = $date9->subMonths(2)->toDateString();
				$birthday3->save();

				$sex3 = new AnimalProperty;
				$sex3->animal_id = $sow3->id;
				$sex3->property_id = $individual3->id;
				$sex3->value = "F";
				$sex3->save();

				$registrationid3 = new AnimalProperty;
				$registrationid3->animal_id = $sow3->id;
				$registrationid3->property_id = $individual2->id;
				$registrationid3->value = $msc->code.$marinduke->breed.'-'.$sex3->value.'01-15';
				$registrationid3->save();
				$this->command->info('AnimalProperty seeded');

				$sow3->registryid = $registrationid3->value;
				$sow3->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow4 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow4->animaltype_id = $pig->id;
				$sow4->farm_id = $msc->id;
				$sow4->breed_id = $marinduke->id;
				$sow4->status = "breeder";
				$sow4->save();
				$this->command->info('Animal seeded');

				$birthday4 = new AnimalProperty;
				$birthday4->animal_id = $sow4->id;
				$birthday4->property_id = $individual1->id;
				$date10 = new Carbon();
				$birthday4->value = $date10->subMonths(2)->toDateString();
				$birthday4->save();

				$sex4 = new AnimalProperty;
				$sex4->animal_id = $sow4->id;
				$sex4->property_id = $individual3->id;
				$sex4->value = "F";
				$sex4->save();

				$registrationid4 = new AnimalProperty;
				$registrationid4->animal_id = $sow4->id;
				$registrationid4->property_id = $individual2->id;
				$registrationid4->value = $msc->code.$marinduke->breed.'-'.$sex4->value.'01-23';
				$registrationid4->save();
				$this->command->info('AnimalProperty seeded');

				$sow4->registryid = $registrationid4->value;
				$sow4->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow5 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow5->animaltype_id = $pig->id;
				$sow5->farm_id = $msc->id;
				$sow5->breed_id = $marinduke->id;
				$sow5->status = "breeder";
				$sow5->save();
				$this->command->info('Animal seeded');

				$birthday5 = new AnimalProperty;
				$birthday5->animal_id = $sow5->id;
				$birthday5->property_id = $individual1->id;
				$date11 = new Carbon();
				$birthday5->value = $date11->subMonths(2)->toDateString();
				$birthday5->save();

				$sex5 = new AnimalProperty;
				$sex5->animal_id = $sow5->id;
				$sex5->property_id = $individual3->id;
				$sex5->value = "F";
				$sex5->save();

				$registrationid5 = new AnimalProperty;
				$registrationid5->animal_id = $sow5->id;
				$registrationid5->property_id = $individual2->id;
				$registrationid5->value = $msc->code.$marinduke->breed.'-'.$sex5->value.'01-31';
				$registrationid5->save();
				$this->command->info('AnimalProperty seeded');

				$sow5->registryid = $registrationid5->value;
				$sow5->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow6 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow6->animaltype_id = $pig->id;
				$sow6->farm_id = $msc->id;
				$sow6->breed_id = $marinduke->id;
				$sow6->status = "breeder";
				$sow6->save();
				$this->command->info('Animal seeded');

				$birthday6 = new AnimalProperty;
				$birthday6->animal_id = $sow6->id;
				$birthday6->property_id = $individual1->id;
				$date12 = new Carbon();
				$birthday6->value = $date12->subMonths(2)->toDateString();
				$birthday6->save();

				$sex6 = new AnimalProperty;
				$sex6->animal_id = $sow6->id;
				$sex6->property_id = $individual3->id;
				$sex6->value = "F";
				$sex6->save();

				$registrationid6 = new AnimalProperty;
				$registrationid6->animal_id = $sow6->id;
				$registrationid6->property_id = $individual2->id;
				$registrationid6->value = $msc->code.$marinduke->breed.'-'.$sex6->value.'00009';
				$registrationid6->save();
				$this->command->info('AnimalProperty seeded');

				$sow6->registryid = $registrationid6->value;
				$sow6->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow7 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow7->animaltype_id = $pig->id;
				$sow7->farm_id = $msc->id;
				$sow7->breed_id = $marinduke->id;
				$sow7->status = "breeder";
				$sow7->save();
				$this->command->info('Animal seeded');

				$birthday7 = new AnimalProperty;
				$birthday7->animal_id = $sow7->id;
				$birthday7->property_id = $individual1->id;
				$date13 = new Carbon();
				$birthday7->value = $date13->subMonths(2)->toDateString();
				$birthday7->save();

				$sex7 = new AnimalProperty;
				$sex7->animal_id = $sow7->id;
				$sex7->property_id = $individual3->id;
				$sex7->value = "F";
				$sex7->save();

				$registrationid7 = new AnimalProperty;
				$registrationid7->animal_id = $sow7->id;
				$registrationid7->property_id = $individual2->id;
				$registrationid7->value = $msc->code.$marinduke->breed.'-'.$sex7->value.'00004';
				$registrationid7->save();
				$this->command->info('AnimalProperty seeded');

				$sow7->registryid = $registrationid7->value;
				$sow7->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow8 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow8->animaltype_id = $pig->id;
				$sow8->farm_id = $msc->id;
				$sow8->breed_id = $marinduke->id;
				$sow8->status = "breeder";
				$sow8->save();
				$this->command->info('Animal seeded');

				$birthday8 = new AnimalProperty;
				$birthday8->animal_id = $sow8->id;
				$birthday8->property_id = $individual1->id;
				$date14 = new Carbon();
				$birthday8->value = $date14->subMonths(2)->toDateString();
				$birthday8->save();

				$sex8 = new AnimalProperty;
				$sex8->animal_id = $sow8->id;
				$sex8->property_id = $individual3->id;
				$sex8->value = "F";
				$sex8->save();

				$registrationid8 = new AnimalProperty;
				$registrationid8->animal_id = $sow8->id;
				$registrationid8->property_id = $individual2->id;
				$registrationid8->value = $msc->code.$marinduke->breed.'-'.$sex8->value.'01-36';
				$registrationid8->save();
				$this->command->info('AnimalProperty seeded');

				$sow8->registryid = $registrationid8->value;
				$sow8->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow9 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow9->animaltype_id = $pig->id;
				$sow9->farm_id = $msc->id;
				$sow9->breed_id = $marinduke->id;
				$sow9->status = "breeder";
				$sow9->save();
				$this->command->info('Animal seeded');

				$birthday9 = new AnimalProperty;
				$birthday9->animal_id = $sow9->id;
				$birthday9->property_id = $individual1->id;
				$date15 = new Carbon();
				$birthday9->value = $date15->subMonths(2)->toDateString();
				$birthday9->save();

				$sex9 = new AnimalProperty;
				$sex9->animal_id = $sow9->id;
				$sex9->property_id = $individual3->id;
				$sex9->value = "F";
				$sex9->save();

				$registrationid9 = new AnimalProperty;
				$registrationid9->animal_id = $sow9->id;
				$registrationid9->property_id = $individual2->id;
				$registrationid9->value = $msc->code.$marinduke->breed.'-'.$sex9->value.'007-4';
				$registrationid9->save();
				$this->command->info('AnimalProperty seeded');

				$sow9->registryid = $registrationid9->value;
				$sow9->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow10 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow10->animaltype_id = $pig->id;
				$sow10->farm_id = $msc->id;
				$sow10->breed_id = $marinduke->id;
				$sow10->status = "breeder";
				$sow10->save();
				$this->command->info('Animal seeded');

				$birthday10 = new AnimalProperty;
				$birthday10->animal_id = $sow10->id;
				$birthday10->property_id = $individual1->id;
				$date16 = new Carbon();
				$birthday10->value = $date16->subMonths(2)->toDateString();
				$birthday10->save();

				$sex10 = new AnimalProperty;
				$sex10->animal_id = $sow10->id;
				$sex10->property_id = $individual3->id;
				$sex10->value = "F";
				$sex10->save();

				$registrationid10 = new AnimalProperty;
				$registrationid10->animal_id = $sow10->id;
				$registrationid10->property_id = $individual2->id;
				$registrationid10->value = $msc->code.$marinduke->breed.'-'.$sex10->value.'001-1';
				$registrationid10->save();
				$this->command->info('AnimalProperty seeded');

				$sow10->registryid = $registrationid10->value;
				$sow10->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow11 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow11->animaltype_id = $pig->id;
				$sow11->farm_id = $msc->id;
				$sow11->breed_id = $marinduke->id;
				$sow11->status = "breeder";
				$sow11->save();
				$this->command->info('Animal seeded');

				$birthday11 = new AnimalProperty;
				$birthday11->animal_id = $sow11->id;
				$birthday11->property_id = $individual1->id;
				$date17 = new Carbon();
				$birthday11->value = $date17->subMonths(2)->toDateString();
				$birthday11->save();

				$sex11 = new AnimalProperty;
				$sex11->animal_id = $sow11->id;
				$sex11->property_id = $individual3->id;
				$sex11->value = "F";
				$sex11->save();

				$registrationid11 = new AnimalProperty;
				$registrationid11->animal_id = $sow11->id;
				$registrationid11->property_id = $individual2->id;
				$registrationid11->value = $msc->code.$marinduke->breed.'-'.$sex11->value.'024-4';
				$registrationid11->save();
				$this->command->info('AnimalProperty seeded');

				$sow11->registryid = $registrationid11->value;
				$sow11->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow12 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow12->animaltype_id = $pig->id;
				$sow12->farm_id = $msc->id;
				$sow12->breed_id = $marinduke->id;
				$sow12->status = "breeder";
				$sow12->save();
				$this->command->info('Animal seeded');

				$birthday12 = new AnimalProperty;
				$birthday12->animal_id = $sow12->id;
				$birthday12->property_id = $individual1->id;
				$date18 = new Carbon();
				$birthday12->value = $date18->subMonths(2)->toDateString();
				$birthday12->save();

				$sex12 = new AnimalProperty;
				$sex12->animal_id = $sow12->id;
				$sex12->property_id = $individual3->id;
				$sex12->value = "F";
				$sex12->save();

				$registrationid12 = new AnimalProperty;
				$registrationid12->animal_id = $sow12->id;
				$registrationid12->property_id = $individual2->id;
				$registrationid12->value = $msc->code.$marinduke->breed.'-'.$sex12->value.'01-34';
				$registrationid12->save();
				$this->command->info('AnimalProperty seeded');

				$sow12->registryid = $registrationid12->value;
				$sow12->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$sow13 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow13->animaltype_id = $pig->id;
				$sow13->farm_id = $msc->id;
				$sow13->breed_id = $marinduke->id;
				$sow13->status = "breeder";
				$sow13->save();
				$this->command->info('Animal seeded');

				$birthday13 = new AnimalProperty;
				$birthday13->animal_id = $sow13->id;
				$birthday13->property_id = $individual1->id;
				$date19 = new Carbon();
				$birthday13->value = $date19->subMonths(2)->toDateString();
				$birthday13->save();

				$sex13 = new AnimalProperty;
				$sex13->animal_id = $sow13->id;
				$sex13->property_id = $individual3->id;
				$sex13->value = "F";
				$sex13->save();

				$registrationid13 = new AnimalProperty;
				$registrationid13->animal_id = $sow13->id;
				$registrationid13->property_id = $individual2->id;
				$registrationid13->value = $msc->code.$marinduke->breed.'-'.$sex13->value.'01-37';
				$registrationid13->save();
				$this->command->info('AnimalProperty seeded');

				$sow13->registryid = $registrationid13->value;
				$sow13->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$boar1 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$boar1->animaltype_id = $pig->id;
				$boar1->farm_id = $msc->id;
				$boar1->breed_id = $marinduke->id;
				$boar1->status = "breeder";
				$boar1->save();
				$this->command->info('Animal seeded');

				$birthday14 = new AnimalProperty;
				$birthday14->animal_id = $boar1->id;
				$birthday14->property_id = $individual1->id;
				$date20 = new Carbon();
				$birthday14->value = $date20->subMonths(2)->toDateString();
				$birthday14->save();

				$sex14 = new AnimalProperty;
				$sex14->animal_id = $boar1->id;
				$sex14->property_id = $individual3->id;
				$sex14->value = "M";
				$sex14->save();

				$registrationid14 = new AnimalProperty;
				$registrationid14->animal_id = $boar1->id;
				$registrationid14->property_id = $individual2->id;
				$registrationid14->value = $msc->code.$marinduke->breed.'-'.$sex14->value.'00005';
				$registrationid14->save();
				$this->command->info('AnimalProperty seeded');

				$boar1->registryid = $registrationid14->value;
				$boar1->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$boar2 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$boar2->animaltype_id = $pig->id;
				$boar2->farm_id = $msc->id;
				$boar2->breed_id = $marinduke->id;
				$boar2->status = "breeder";
				$boar2->save();
				$this->command->info('Animal seeded');

				$birthday15 = new AnimalProperty;
				$birthday15->animal_id = $boar2->id;
				$birthday15->property_id = $individual1->id;
				$date21 = new Carbon();
				$birthday15->value = $date21->subMonths(2)->toDateString();
				$birthday15->save();

				$sex15 = new AnimalProperty;
				$sex15->animal_id = $boar2->id;
				$sex15->property_id = $individual3->id;
				$sex15->value = "M";
				$sex15->save();

				$registrationid15 = new AnimalProperty;
				$registrationid15->animal_id = $boar2->id;
				$registrationid15->property_id = $individual2->id;
				$registrationid15->value = $msc->code.$marinduke->breed.'-'.$sex15->value.'00008';
				$registrationid15->save();
				$this->command->info('AnimalProperty seeded');

				$boar2->registryid = $registrationid15->value;
				$boar2->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$boar3 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$boar3->animaltype_id = $pig->id;
				$boar3->farm_id = $msc->id;
				$boar3->breed_id = $marinduke->id;
				$boar3->status = "breeder";
				$boar3->save();
				$this->command->info('Animal seeded');

				$birthday16 = new AnimalProperty;
				$birthday16->animal_id = $boar3->id;
				$birthday16->property_id = $individual1->id;
				$date22 = new Carbon();
				$birthday16->value = $date22->subMonths(2)->toDateString();
				$birthday16->save();

				$sex16 = new AnimalProperty;
				$sex16->animal_id = $boar3->id;
				$sex16->property_id = $individual3->id;
				$sex16->value = "M";
				$sex16->save();

				$registrationid16 = new AnimalProperty;
				$registrationid16->animal_id = $boar3->id;
				$registrationid16->property_id = $individual2->id;
				$registrationid16->value = $msc->code.$marinduke->breed.'-'.$sex16->value.'00001';
				$registrationid16->save();
				$this->command->info('AnimalProperty seeded');

				$boar3->registryid = $registrationid16->value;
				$boar3->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$boar4 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$boar4->animaltype_id = $pig->id;
				$boar4->farm_id = $msc->id;
				$boar4->breed_id = $marinduke->id;
				$boar4->status = "breeder";
				$boar4->save();
				$this->command->info('Animal seeded');

				$birthday17 = new AnimalProperty;
				$birthday17->animal_id = $boar4->id;
				$birthday17->property_id = $individual1->id;
				$date23 = new Carbon();
				$birthday17->value = $date23->subMonths(2)->toDateString();
				$birthday17->save();

				$sex17 = new AnimalProperty;
				$sex17->animal_id = $boar4->id;
				$sex17->property_id = $individual3->id;
				$sex17->value = "M";
				$sex17->save();

				$registrationid17 = new AnimalProperty;
				$registrationid17->animal_id = $boar4->id;
				$registrationid17->property_id = $individual2->id;
				$registrationid17->value = $msc->code.$marinduke->breed.'-'.$sex17->value.'008-7';
				$registrationid17->save();
				$this->command->info('AnimalProperty seeded');

				$boar4->registryid = $registrationid17->value;
				$boar4->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$boar5 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$boar5->animaltype_id = $pig->id;
				$boar5->farm_id = $msc->id;
				$boar5->breed_id = $marinduke->id;
				$boar5->status = "breeder";
				$boar5->save();
				$this->command->info('Animal seeded');

				$birthday18 = new AnimalProperty;
				$birthday18->animal_id = $boar5->id;
				$birthday18->property_id = $individual1->id;
				$date24 = new Carbon();
				$birthday18->value = $date24->subMonths(2)->toDateString();
				$birthday18->save();

				$sex18 = new AnimalProperty;
				$sex18->animal_id = $boar5->id;
				$sex18->property_id = $individual3->id;
				$sex18->value = "M";
				$sex18->save();

				$registrationid18 = new AnimalProperty;
				$registrationid18->animal_id = $boar5->id;
				$registrationid18->property_id = $individual2->id;
				$registrationid18->value = $msc->code.$marinduke->breed.'-'.$sex18->value.'008-7';
				$registrationid18->save();
				$this->command->info('AnimalProperty seeded');

				$boar5->registryid = $registrationid8->value;
				$boar5->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$grouping = new Grouping;
				$grouping->registryid = $sow1->registryid;
				$grouping->mother_id = $sow1->id;
				$grouping->father_id = $boar1->id;
				$grouping->save();

				$this->command->info('Animals added to group');

				$date6 = new Carbon();

				$groupprop = new GroupingProperty;
				$groupprop->grouping_id = $grouping->id;
				$groupprop->property_id = $mating1->id;
				$groupprop->value = $date6->subMonths(1);
				$groupprop->datecollected = new Carbon();
				$groupprop->save();

				$groupprop2 = new GroupingProperty;
				$groupprop2->grouping_id = $grouping->id;
				$groupprop2->property_id = $mating2->id;
				$groupprop2->value = $date6->addDays(114);
				$groupprop2->datecollected = new Carbon();
				$groupprop2->save();

				$groupprop3 = new GroupingProperty;
				$groupprop3->grouping_id = $grouping->id;
				$groupprop3->property_id = $mating4->id;
				$groupprop3->value = 0;
				$groupprop3->datecollected = new Carbon();
				$groupprop3->save();

				$groupprop4 = new GroupingProperty;
				$groupprop4->grouping_id = $grouping->id;
				$groupprop4->property_id = $mating3->id;
				$groupprop4->value = "Pregnant";
				$groupprop4->datecollected = new Carbon();
				$groupprop4->save();

				$groupprop5 = new GroupingProperty;
				$groupprop5->grouping_id = $grouping->id;
				$groupprop5->property_id = $individual1->id;
				$groupprop5->value = new Carbon();
				$groupprop5->datecollected = new Carbon();
				$groupprop5->save();

				$groupprop6 = new GroupingProperty;
				$groupprop6->grouping_id = $grouping->id;
				$groupprop6->property_id = $slr1->id;
				$groupprop6->value = $date6->addDays(124);
				$groupprop6->datecollected = new Carbon();
				$groupprop6->save();

				$this->command->info('Pig grouping properties seeded');
		}

}
