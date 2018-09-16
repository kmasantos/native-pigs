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

				$bai = new Farm;
				$bai->name = "BAI-NSPRDC";
				$bai->code = "QUEBAI";
				$bai->province = "Quezon";

				$baiUser = new User;
				$baiUser->name = "BAI";
				$baiUser->email = "baibppig@gmail.com";

				$bsu = new Farm;
				$bsu->name = "Benguet State University";
				$bsu->code = "BENBSU";
				$bsu->province = "Benguet";

				$bsuUser = new User;
				$bsuUser->name = "BSU";
				$bsuUser->email = "benguetpig@gmail.com";

				$essu = new Farm;
				$essu->name = "Eastern Samar State University";
				$essu->code = "EASESSU";
				$essu->province = "Eastern Samar";

				$essuUser = new User;
				$essuUser->name = "ESSU";
				$essuUser->email = "siniranganpig@gmail.com";

				$ias = new Farm;
				$ias->name = "UPLB Institute of Animal Science";
				$ias->code = "LAGIAS";
				$ias->province = "Laguna";

				$iasUser = new User;
				$iasUser->name = "IAS";
				$iasUser->email = "berkjalapig@gmail.com";

				$isu = new Farm;
				$isu->name = "Isabela State University";
				$isu->code = "ISAISU";
				$isu->province = "Isabela";

				$isuUser = new User;
				$isuUser->name = "ISU";
				$isuUser->email = "isabelaisupig@gmail.com";

				$ksu = new Farm;
				$ksu->name = "Kalinga State University";
				$ksu->code = "KAKSU";
				$ksu->province = "Kalinga";

				$ksuUser = new User;
				$ksuUser->name = "KSU";
				$ksuUser->email = "yookahpig@gmail.com";

				$msc = new Farm;
				$msc->name = "Marinduque State College";
				$msc->code = "MARMSC";
				$msc->province = "Marinduque";

				$mscUser = new User;
				$mscUser->name = "MSC";
				$mscUser->email = "marindukepig@gmail.com";

				$nvsu = new Farm;
				$nvsu->name = "Nueva Vizcaya State University";
				$nvsu->code = "NUVNVSU";
				$nvsu->province = "Nueva Vizcaya";

				$nvsuUser = new User;
				$nvsuUser->name = "NVSU";
				$nvsuUser->email = "nuevaviscayapig@gmail.com";

				$group = new Grouping;

				/**********************************/
				/*********** Pig Seeder ***********/
				/**********************************/

				$individual1 = new Property;
				$individual1->name = "Earnotch";
				$individual1->fname = "earnotch";
				$individual1->description = "Earnotch or eartag number of the pig";
				$individual1->save();

				$individual2 = new Property;
				$individual2->name = "Sex";
				$individual2->fname = "sex";
				$individual2->description = "Sex of the pig";
				$individual2->save();

				$individual3 = new Property;
				$individual3->name = "Date Farrowed";
				$individual3->fname = "date_farrowed";
				$individual3->description = "Date when pig was born";
				$individual3->save();

				$individual4 = new Property;
				$individual4->name = "Registration ID";
				$individual4->fname = "registration_id";
				$individual4->description = "Complete registration ID of the pig";
				$individual4->save();

				$individual5 = new Property;
				$individual5->name = "Birth Weight";
				$individual5->fname = "birth_weight";
				$individual5->description = "Weight of the pig when it was born";
				$individual5->save();

				$individual6 = new Property;
				$individual6->name = "Date Weaned";
				$individual6->fname = "date_weaned";
				$individual6->description = "Date when pig was weaned";
				$individual6->save();

				$individual7 = new Property;
				$individual7->name = "Weaning Weight";
				$individual7->fname = "weaning_weight";
				$individual7->description = "Weight of the pig when it was weaned";
				$individual7->save();

				$individual8 = new Property;
				$individual8->name = "Dam";
				$individual8->fname = "dam";
				$individual8->description = "Mother of the pig";
				$individual8->save();

				$individual9 = new Property;
				$individual9->name = "Sire";
				$individual9->fname = "sire";
				$individual9->description = "Father of the pig";
				$individual9->save();

				$this->command->info('Pig individual properties seeded');

				//Gross Morphology
				$grossmorpho1 = new Property;
				$grossmorpho1->name = "Date Collected for Gross Morphology";
				$grossmorpho1->fname = "date_collected_gross_morpho";
				$grossmorpho1->description = "Date when gross morphology was collected";
				$grossmorpho1->save();

				$grossmorpho2 = new Property;
				$grossmorpho2->name = "Hair Type";
				$grossmorpho2->fname = "hair_type";
				$grossmorpho2->description = "Hair type of the pig";
				$grossmorpho2->save();

				$grossmorpho3 = new Property;
				$grossmorpho3->name = "Hair Length";
				$grossmorpho3->fname = "hair_length";
				$grossmorpho3->description = "Hair length classification of the pig";
				$grossmorpho3->save();

				$grossmorpho4 = new Property;
				$grossmorpho4->name = "Coat Color";
				$grossmorpho4->fname = "coat_color";
				$grossmorpho4->description = "Coat color of the pig";
				$grossmorpho4->save();

				$grossmorpho5 = new Property;
				$grossmorpho5->name = "Color Pattern";
				$grossmorpho5->fname = "color_pattern";
				$grossmorpho5->description = "Color pattern of the coat of the pig";
				$grossmorpho5->save();

				$grossmorpho6 = new Property;
				$grossmorpho6->name = "Head Shape";
				$grossmorpho6->fname = "head_shape";
				$grossmorpho6->description = "Head shape of the pig";
				$grossmorpho6->save();

				$grossmorpho7 = new Property;
				$grossmorpho7->name = "Skin Type";
				$grossmorpho7->fname = "skin_type";
				$grossmorpho7->description = "Skin Type of the pig";
				$grossmorpho7->save();

				$grossmorpho8 = new Property;
				$grossmorpho8->name = "Ear Type";
				$grossmorpho8->fname = "ear_type";
				$grossmorpho8->description = "Ear type of the pig";
				$grossmorpho8->save();

				$grossmorpho9 = new Property;
				$grossmorpho9->name = "Tail Type";
				$grossmorpho9->fname = "tail_type";
				$grossmorpho9->description = "Tail type of the pig";
				$grossmorpho9->save();

				$grossmorpho10 = new Property;
				$grossmorpho10->name = "Backline";
				$grossmorpho10->fname = "backline";
				$grossmorpho10->description = "Backline of the pig";
				$grossmorpho10->save();

				$grossmorpho11 = new Property;
				$grossmorpho11->name = "Other Marks";
				$grossmorpho11->fname = "other_marks";
				$grossmorpho11->description = "Other marks that can identify the pig";
				$grossmorpho11->save();

				$this->command->info('Pig gross morphology properties seeded');

				//morphometric characteristics
				$morphochars1 = new Property;
				$morphochars1->name = "Date Collected for Morphometric Characteristics";
				$morphochars1->fname = "date_collected_morpho_chars";
				$morphochars1->description = "Date when morphometric characteristics were collected";
				$morphochars1->save();

				$morphochars2 = new Property;
				$morphochars2->name = "Ear Length";
				$morphochars2->fname = "ear_length";
				$morphochars2->description = "Ear length of the pig";
				$morphochars2->save();

				$morphochars3 = new Property;
				$morphochars3->name = "Head Length";
				$morphochars3->fname = "head_length";
				$morphochars3->description = "Head length of the pig";
				$morphochars3->save();

				$morphochars4 = new Property;
				$morphochars4->name = "Snout Length";
				$morphochars4->fname = "snout_length";
				$morphochars4->description = "Snout length of the pig";
				$morphochars4->save();

				$morphochars5 = new Property;
				$morphochars5->name = "Body Length";
				$morphochars5->fname = "body_length";
				$morphochars5->description = "Body length of the pig";
				$morphochars5->save();

				$morphochars6 = new Property;
				$morphochars6->name = "Heart Girth";
				$morphochars6->fname = "heart_girth";
				$morphochars6->description = "Heart girth of the pig";
				$morphochars6->save();

				$morphochars7 = new Property;
				$morphochars7->name = "Pelvic Width";
				$morphochars7->fname = "pelvic_width";
				$morphochars7->description = "Pelvic width of the pig";
				$morphochars7->save();

				$morphochars8 = new Property;
				$morphochars8->name = "Tail Length";
				$morphochars8->fname = "tail_length";
				$morphochars8->description = "Tail length of the pig";
				$morphochars8->save();

				$morphochars9 = new Property;
				$morphochars9->name = "Height at Withers";
				$morphochars9->fname = "height_at_withers";
				$morphochars9->description = "Height at withers of the pig";
				$morphochars9->save();

				$morphochars10 = new Property;
				$morphochars10->name = "Number of Normal Teats";
				$morphochars10->fname = "number_normal_teats";
				$morphochars10->description = "Number of the normal teats of the pig";
				$morphochars10->save();

				$morphochars11 = new Property;
				$morphochars11->name = "Ponderal Index";
				$morphochars11->fname = "ponderal_index";
				$morphochars11->description = "Computed ponderal index of the pig";
				$morphochars11->save();

				$this->command->info('Pig morphometric properties seeded');

				//body weights
				$weightrecord1 = new Property;
				$weightrecord1->name = "Body Weight at 45 Days";
				$weightrecord1->fname = "body_weight_at_45_days";
				$weightrecord1->description = "Body weight of the pig at 45 days";
				$weightrecord1->save();

				$weightrecord2 = new Property;
				$weightrecord2->name = "Body Weight at 60 Days";
				$weightrecord2->fname = "body_weight_at_60_days";
				$weightrecord2->description = "Body weight of the pig at 60 days";
				$weightrecord2->save();

				$weightrecord3 = new Property;
				$weightrecord3->name = "Body Weight at 90 Days";
				$weightrecord3->fname = "body_weight_at_90_days";
				$weightrecord3->description = "Body weight of the pig at 90 days";
				$weightrecord3->save();

				$weightrecord4 = new Property;
				$weightrecord4->name = "Body Weight at 150 Days";
				$weightrecord4->fname = "body_weight_at_150_days";
				$weightrecord4->description = "Body weight of the pig at 150 days";
				$weightrecord4->save();

				$weightrecord5 = new Property;
				$weightrecord5->name = "Body Weight at 180 Days";
				$weightrecord5->fname = "body_weight_at_180_days";
				$weightrecord5->description = "Body weight of the pig at 180 days";
				$weightrecord5->save();

				$weightrecord6 = new Property;
				$weightrecord6->name = "Date Colleceted at 45 Days";
				$weightrecord6->fname = "date_collected_at_45_days";
				$weightrecord6->description = "Date when body weight at 45 days was collected";
				$weightrecord6->save();

				$weightrecord7 = new Property;
				$weightrecord7->name = "Date Colleceted at 60 Days";
				$weightrecord7->fname = "date_collected_at_60_days";
				$weightrecord7->description = "Date when body weight at 60 days was collected";
				$weightrecord7->save();

				$weightrecord8 = new Property;
				$weightrecord8->name = "Date Colleceted at 90 Days";
				$weightrecord8->fname = "date_collected_at_90_days";
				$weightrecord8->description = "Date when body weight at 90 days was collected";
				$weightrecord8->save();

				$weightrecord9 = new Property;
				$weightrecord9->name = "Date Colleceted at 150 Days";
				$weightrecord9->fname = "date_collected_at_150_days";
				$weightrecord9->description = "Date when body weight at 150 days was collected";
				$weightrecord9->save();

				$weightrecord10 = new Property;
				$weightrecord10->name = "Date Colleceted at 180 Days";
				$weightrecord10->fname = "date_collected_at_180_days";
				$weightrecord10->description = "Date when body weight at 180 days was collected";
				$weightrecord10->save();

				$this->command->info('Pig body weight properties seeded');

				$breeding1 = new Property;
				$breeding1->name = "Date Bred";
				$breeding1->fname = "date_bred";
				$breeding1->description = "Date when two pigs were bred";
				$breeding1->save();

				$breeding2 = new Property;
				$breeding2->name = "Expected Date of Farrowing";
				$breeding2->fname = "expected_date_of_farrowing";
				$breeding2->description = "Expected date of farrowing";
				$breeding2->save();

				$breeding3 = new Property;
				$breeding3->name = "Date Aborted";
				$breeding3->fname = "date_aborted";
				$breeding3->description = "Date when litters were aborted";
				$breeding3->save();

				$this->command->info('Pig breeding properties seeded');

				$sowlitter1 = new Property;
				$sowlitter1->name = "Number Stillborn";
				$sowlitter1->fname = "number_stillborn";
				$sowlitter1->description = "Number of stillbirths";
				$sowlitter1->save();

				$sowlitter2 = new Property;
				$sowlitter2->name = "Number Mummified";
				$sowlitter2->fname = "number_mummified";
				$sowlitter2->description = "Number of mummified offspring";
				$sowlitter2->save();

				$sowlitter3 = new Property;
				$sowlitter3->name = "Abnormalities";
				$sowlitter3->fname = "abnormalities";
				$sowlitter3->description = "Abnomalities of the litter";
				$sowlitter3->save();

				$sowlitter4 = new Property;
				$sowlitter4->name = "Parity";
				$sowlitter4->fname = "parity";
				$sowlitter4->description = "Parity of the sow";
				$sowlitter4->save();

				$sowlitter5 = new Property;
				$sowlitter5->name = "Total Littersize Born";
				$sowlitter5->fname = "lsb";
				$sowlitter5->description = "Total litters born";
				$sowlitter5->save();

				$sowlitter6 = new Property;
				$sowlitter6->name = "Total Littersize Born Alive";
				$sowlitter6->fname = "lsba";
				$sowlitter6->description = "Total litters born alive";
				$sowlitter6->save();

				$sowlitter7 = new Property;
				$sowlitter7->name = "Number of Males";
				$sowlitter7->fname = "number_males";
				$sowlitter7->description = "Number of males born";
				$sowlitter7->save();

				$sowlitter8 = new Property;
				$sowlitter8->name = "Number of Females";
				$sowlitter8->fname = "number_females";
				$sowlitter8->description = "Number of females born";
				$sowlitter8->save();

				$sowlitter9 = new Property;
				$sowlitter9->name = "Sex Ratio";
				$sowlitter9->fname = "sex_ratio";
				$sowlitter9->description = "Sex ratio of the litters";
				$sowlitter9->save();

				$sowlitter10 = new Property;
				$sowlitter10->name = "Weighing Option";
				$sowlitter10->fname = "weighing_option";
				$sowlitter10->description = "Weighing option of the farm";
				$sowlitter10->save();

				$sowlitter11 = new Property;
				$sowlitter11->name = "Litter Birth Weight";
				$sowlitter11->fname = "litter_birth_weight";
				$sowlitter11->description = "Litter birth weight";
				$sowlitter11->save();

				$sowlitter12 = new Property;
				$sowlitter12->name = "Average Birth Weight";
				$sowlitter12->fname = "average_birth_weight";
				$sowlitter12->description = "Average birth weight";
				$sowlitter12->save();

				$sowlitter13 = new Property;
				$sowlitter13->name = "Number Weaned";
				$sowlitter13->fname = "number_weaned";
				$sowlitter13->description = "Number of pigs weaned";
				$sowlitter13->save();

				$sowlitter14 = new Property;
				$sowlitter14->name = "Average Weaning Weight";
				$sowlitter14->fname = "average_weaning_weight";
				$sowlitter14->description = "Average weaning weight";
				$sowlitter14->save();

				$sowlitter15 = new Property;
				$sowlitter15->name = "Preweaning Mortality";
				$sowlitter15->fname = "preweaning_mortality";
				$sowlitter15->description = "Number of pigs which died before weaning";
				$sowlitter15->save();

				$this->command->info('Pig sow and litter properties seeded');

				$additional1 = new Property;
				$additional1->name = "Status";
				$additional1->fname = "status";
				$additional1->description = "Any status used in the information system";
				$additional1->save();

				$additional2 = new Property;
				$additional2->name = "Frequency";
				$additional2->fname = "frequency";
				$additional2->description = "Number of times sow or boar was used in breeding";
				$additional2->save();

				$additional3 = new Property;
				$additional3->name = "Litter Weaning Weight";
				$additional3->fname = "litter_weaning_weight";
				$additional3->description = "Litter weaning weight";
				$additional3->save();

				$this->command->info('Additional properties seeded');
				$this->command->info('All properties seeded');

				$chicken = new AnimalType;
				$chicken->species = "chicken";
				$chicken->save();

				$duck = new AnimalType;
				$duck->species = "duck";
				$duck->save();

				$pig = new AnimalType;
				$pig->species = "pig";
				$pig->save();

				$this->command->info('Animaltypes seeded');

				$bp = new Breed;
				$bp->breed = "BP";
				$bp->animaltype_id = $pig->id;
				$bp->save();

				$benguet = new Breed;
				$benguet->breed = "Benguet";
				$benguet->animaltype_id = $pig->id;
				$benguet->save();

				$sinirangan = new Breed;
				$sinirangan->breed = "Sinirangan";
				$sinirangan->animaltype_id = $pig->id;
				$sinirangan->save();

				$berkjala =  new Breed;
				$berkjala->breed = "Berkjala";
				$berkjala->animaltype_id = $pig->id;
				$berkjala->save();

				$isabela = new Breed;
				$isabela->breed = "Isabela";
				$isabela->animaltype_id = $pig->id;
				$isabela->save();

				$yookah = new Breed;
				$yookah->breed = "Yookah";
				$yookah->animaltype_id = $pig->id;
				$yookah->save();

				$marinduke = new Breed;
				$marinduke->breed = "Marinduke";
				$marinduke->animaltype_id = $pig->id;
				$marinduke->save();

				$nuevavizcaya = new Breed;
				$nuevavizcaya->breed = "NuevaVizcaya";
				$nuevavizcaya->animaltype_id = $pig->id;
				$nuevavizcaya->save();

				$this->command->info('Breeds seeded');

				$bai->breedable_id = $bp->id;
				$bai->save();
				$bai->users()->save($baiUser);

				$bsu->breedable_id = $benguet->id;
				$bsu->save();
				$bsu->users()->save($bsuUser);

				$essu->breedable_id = $sinirangan->id;
				$essu->save();
				$essu->users()->save($essuUser);

				$ias->breedable_id = $berkjala->id;
				$ias->save();
				$ias->users()->save($iasUser);

				$isu->breedable_id = $isabela->id;
				$isu->save();
				$isu->users()->save($isuUser);

				$ksu->breedable_id = $yookah->id;
				$ksu->save();
				$ksu->users()->save($ksuUser);

				$msc->breedable_id = $marinduke->id;
				$msc->save();
				$msc->users()->save($mscUser);

				$nvsu->breedable_id = $nuevavizcaya->id;
				$nvsu->save();
				$nvsu->users()->save($nvsuUser);

				$this->command->info('Users seeded');

				/* MARINDUQUE DATA SEEDERS */

				/* SOWS */
				$sow1 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$sow1->animaltype_id = $pig->id;
				$sow1->farm_id = $msc->id;
				$sow1->breed_id = $marinduke->id;
				$sow1->status = "breeder";
				$sow1->save();
				$this->command->info('Animal seeded');

				$earnotch1 = new AnimalProperty;
				$earnotch1->animal_id = $sow1->id;
				$earnotch1->property_id = $individual1->id;
				$earnotch1->value = "0001-2";
				$earnotch1->save();

				$sex1 = new AnimalProperty;
				$sex1->animal_id = $sow1->id;
				$sex1->property_id = $individual2->id;
				$sex1->value = "F";
				$sex1->save();

				$datefarrowed1 = new AnimalProperty;
				$datefarrowed1->animal_id = $sow1->id;
				$datefarrowed1->property_id = $individual3->id;
				$datefarrowed1->value = "Not specified";
				$datefarrowed1->save();

				$registrationid1 = new AnimalProperty;
				$registrationid1->animal_id = $sow1->id;
				$registrationid1->property_id = $individual4->id;
				$registrationid1->value = $msc->code.$marinduke->breed.'-'.$sex1->value.$earnotch1->value;
				$registrationid1->save();

				$birthweight1 = new AnimalProperty;
				$birthweight1->animal_id = $sow1->id;
				$birthweight1->property_id = $individual5->id;
				$birthweight1->value = "";
				$birthweight1->save();

				$dateweaned1 = new AnimalProperty;
				$dateweaned1->animal_id = $sow1->id;
				$dateweaned1->property_id = $individual6->id;
				$dateweaned1->value = "Not specified";
				$dateweaned1->save();

				$weaningweight1 = new AnimalProperty;
				$weaningweight1->animal_id = $sow1->id;
				$weaningweight1->property_id = $individual7->id;
				$weaningweight1->value = "";
				$weaningweight1->save();

				$dam1 = new AnimalProperty;
				$dam1->animal_id = $sow1->id;
				$dam1->property_id = $individual8->id;
				$dam1->value = "Not specified";
				$dam1->save();

				$sire1 = new AnimalProperty;
				$sire1->animal_id = $sow1->id;
				$sire1->property_id = $individual9->id;
				$sire1->value = "Not specified";
				$sire1->save();

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

				$earnotch2 = new AnimalProperty;
				$earnotch2->animal_id = $sow2->id;
				$earnotch2->property_id = $individual1->id;
				$earnotch2->value = "001-10";
				$earnotch2->save();

				$sex2 = new AnimalProperty;
				$sex2->animal_id = $sow2->id;
				$sex2->property_id = $individual2->id;
				$sex2->value = "F";
				$sex2->save();

				$datefarrowed2 = new AnimalProperty;
				$datefarrowed2->animal_id = $sow2->id;
				$datefarrowed2->property_id = $individual3->id;
				$datefarrowed2->value = "Not specified";
				$datefarrowed2->save();

				$registrationid2 = new AnimalProperty;
				$registrationid2->animal_id = $sow2->id;
				$registrationid2->property_id = $individual4->id;
				$registrationid2->value = $msc->code.$marinduke->breed.'-'.$sex2->value.$earnotch2->value;
				$registrationid2->save();

				$birthweight2 = new AnimalProperty;
				$birthweight2->animal_id = $sow2->id;
				$birthweight2->property_id = $individual5->id;
				$birthweight2->value = "";
				$birthweight2->save();

				$dateweaned2 = new AnimalProperty;
				$dateweaned2->animal_id = $sow2->id;
				$dateweaned2->property_id = $individual6->id;
				$dateweaned2->value = "Not specified";
				$dateweaned2->save();

				$weaningweight2 = new AnimalProperty;
				$weaningweight2->animal_id = $sow2->id;
				$weaningweight2->property_id = $individual7->id;
				$weaningweight2->value = "";
				$weaningweight2->save();

				$dam2 = new AnimalProperty;
				$dam2->animal_id = $sow2->id;
				$dam2->property_id = $individual8->id;
				$dam2->value = "Not specified";
				$dam2->save();

				$sire2 = new AnimalProperty;
				$sire2->animal_id = $sow2->id;
				$sire2->property_id = $individual9->id;
				$sire2->value = "Not specified";
				$sire2->save();

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

				$earnotch3 = new AnimalProperty;
				$earnotch3->animal_id = $sow3->id;
				$earnotch3->property_id = $individual1->id;
				$earnotch3->value = "001-15";
				$earnotch3->save();

				$sex3 = new AnimalProperty;
				$sex3->animal_id = $sow3->id;
				$sex3->property_id = $individual2->id;
				$sex3->value = "F";
				$sex3->save();

				$datefarrowed3 = new AnimalProperty;
				$datefarrowed3->animal_id = $sow3->id;
				$datefarrowed3->property_id = $individual3->id;
				$datefarrowed3->value = "Not specified";
				$datefarrowed3->save();

				$registrationid3 = new AnimalProperty;
				$registrationid3->animal_id = $sow3->id;
				$registrationid3->property_id = $individual4->id;
				$registrationid3->value = $msc->code.$marinduke->breed.'-'.$sex3->value.$earnotch3->value;
				$registrationid3->save();

				$birthweight3 = new AnimalProperty;
				$birthweight3->animal_id = $sow3->id;
				$birthweight3->property_id = $individual5->id;
				$birthweight3->value = "";
				$birthweight3->save();

				$dateweaned3 = new AnimalProperty;
				$dateweaned3->animal_id = $sow3->id;
				$dateweaned3->property_id = $individual6->id;
				$dateweaned3->value = "Not specified";
				$dateweaned3->save();

				$weaningweight3 = new AnimalProperty;
				$weaningweight3->animal_id = $sow3->id;
				$weaningweight3->property_id = $individual7->id;
				$weaningweight3->value = "";
				$weaningweight3->save();

				$dam3 = new AnimalProperty;
				$dam3->animal_id = $sow3->id;
				$dam3->property_id = $individual8->id;
				$dam3->value = "Not specified";
				$dam3->save();

				$sire3 = new AnimalProperty;
				$sire3->animal_id = $sow3->id;
				$sire3->property_id = $individual9->id;
				$sire3->value = "Not specified";
				$sire3->save();

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

				$earnotch4 = new AnimalProperty;
				$earnotch4->animal_id = $sow4->id;
				$earnotch4->property_id = $individual1->id;
				$earnotch4->value = "001-23";
				$earnotch4->save();

				$sex4 = new AnimalProperty;
				$sex4->animal_id = $sow4->id;
				$sex4->property_id = $individual2->id;
				$sex4->value = "F";
				$sex4->save();

				$datefarrowed4 = new AnimalProperty;
				$datefarrowed4->animal_id = $sow4->id;
				$datefarrowed4->property_id = $individual3->id;
				$datefarrowed4->value = "Not specified";
				$datefarrowed4->save();

				$registrationid4 = new AnimalProperty;
				$registrationid4->animal_id = $sow4->id;
				$registrationid4->property_id = $individual4->id;
				$registrationid4->value = $msc->code.$marinduke->breed.'-'.$sex4->value.$earnotch4->value;
				$registrationid4->save();

				$birthweight4 = new AnimalProperty;
				$birthweight4->animal_id = $sow4->id;
				$birthweight4->property_id = $individual5->id;
				$birthweight4->value = "";
				$birthweight4->save();

				$dateweaned4 = new AnimalProperty;
				$dateweaned4->animal_id = $sow4->id;
				$dateweaned4->property_id = $individual6->id;
				$dateweaned4->value = "Not specified";
				$dateweaned4->save();

				$weaningweight4 = new AnimalProperty;
				$weaningweight4->animal_id = $sow4->id;
				$weaningweight4->property_id = $individual7->id;
				$weaningweight4->value = "";
				$weaningweight4->save();

				$dam4 = new AnimalProperty;
				$dam4->animal_id = $sow4->id;
				$dam4->property_id = $individual8->id;
				$dam4->value = "Not specified";
				$dam4->save();

				$sire4 = new AnimalProperty;
				$sire4->animal_id = $sow4->id;
				$sire4->property_id = $individual9->id;
				$sire4->value = "Not specified";
				$sire4->save();

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

				$earnotch5 = new AnimalProperty;
				$earnotch5->animal_id = $sow5->id;
				$earnotch5->property_id = $individual1->id;
				$earnotch5->value = "001-31";
				$earnotch5->save();

				$sex5 = new AnimalProperty;
				$sex5->animal_id = $sow5->id;
				$sex5->property_id = $individual2->id;
				$sex5->value = "F";
				$sex5->save();

				$datefarrowed5 = new AnimalProperty;
				$datefarrowed5->animal_id = $sow5->id;
				$datefarrowed5->property_id = $individual3->id;
				$datefarrowed5->value = "Not specified";
				$datefarrowed5->save();

				$registrationid5 = new AnimalProperty;
				$registrationid5->animal_id = $sow5->id;
				$registrationid5->property_id = $individual4->id;
				$registrationid5->value = $msc->code.$marinduke->breed.'-'.$sex5->value.$earnotch5->value;
				$registrationid5->save();

				$birthweight5 = new AnimalProperty;
				$birthweight5->animal_id = $sow5->id;
				$birthweight5->property_id = $individual5->id;
				$birthweight5->value = "";
				$birthweight5->save();

				$dateweaned5 = new AnimalProperty;
				$dateweaned5->animal_id = $sow5->id;
				$dateweaned5->property_id = $individual6->id;
				$dateweaned5->value = "Not specified";
				$dateweaned5->save();

				$weaningweight5 = new AnimalProperty;
				$weaningweight5->animal_id = $sow5->id;
				$weaningweight5->property_id = $individual7->id;
				$weaningweight5->value = "";
				$weaningweight5->save();

				$dam5 = new AnimalProperty;
				$dam5->animal_id = $sow5->id;
				$dam5->property_id = $individual8->id;
				$dam5->value = "Not specified";
				$dam5->save();

				$sire5 = new AnimalProperty;
				$sire5->animal_id = $sow5->id;
				$sire5->property_id = $individual9->id;
				$sire5->value = "Not specified";
				$sire5->save();

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

				$earnotch6 = new AnimalProperty;
				$earnotch6->animal_id = $sow6->id;
				$earnotch6->property_id = $individual1->id;
				$earnotch6->value = "000009";
				$earnotch6->save();

				$sex6 = new AnimalProperty;
				$sex6->animal_id = $sow6->id;
				$sex6->property_id = $individual2->id;
				$sex6->value = "F";
				$sex6->save();

				$datefarrowed6 = new AnimalProperty;
				$datefarrowed6->animal_id = $sow6->id;
				$datefarrowed6->property_id = $individual3->id;
				$datefarrowed6->value = "Not specified";
				$datefarrowed6->save();

				$registrationid6 = new AnimalProperty;
				$registrationid6->animal_id = $sow6->id;
				$registrationid6->property_id = $individual4->id;
				$registrationid6->value = $msc->code.$marinduke->breed.'-'.$sex6->value.$earnotch6->value;
				$registrationid6->save();

				$birthweight6 = new AnimalProperty;
				$birthweight6->animal_id = $sow6->id;
				$birthweight6->property_id = $individual5->id;
				$birthweight6->value = "";
				$birthweight6->save();

				$dateweaned6 = new AnimalProperty;
				$dateweaned6->animal_id = $sow6->id;
				$dateweaned6->property_id = $individual6->id;
				$dateweaned6->value = "Not specified";
				$dateweaned6->save();

				$weaningweight6 = new AnimalProperty;
				$weaningweight6->animal_id = $sow6->id;
				$weaningweight6->property_id = $individual7->id;
				$weaningweight6->value = "";
				$weaningweight6->save();

				$dam6 = new AnimalProperty;
				$dam6->animal_id = $sow6->id;
				$dam6->property_id = $individual8->id;
				$dam6->value = "Not specified";
				$dam6->save();

				$sire6 = new AnimalProperty;
				$sire6->animal_id = $sow6->id;
				$sire6->property_id = $individual9->id;
				$sire6->value = "Not specified";
				$sire6->save();

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

				$earnotch7 = new AnimalProperty;
				$earnotch7->animal_id = $sow7->id;
				$earnotch7->property_id = $individual1->id;
				$earnotch7->value = "000004";
				$earnotch7->save();

				$sex7 = new AnimalProperty;
				$sex7->animal_id = $sow7->id;
				$sex7->property_id = $individual2->id;
				$sex7->value = "F";
				$sex7->save();

				$datefarrowed7 = new AnimalProperty;
				$datefarrowed7->animal_id = $sow7->id;
				$datefarrowed7->property_id = $individual3->id;
				$datefarrowed7->value = "Not specified";
				$datefarrowed7->save();

				$registrationid7 = new AnimalProperty;
				$registrationid7->animal_id = $sow7->id;
				$registrationid7->property_id = $individual4->id;
				$registrationid7->value = $msc->code.$marinduke->breed.'-'.$sex7->value.$earnotch7->value;
				$registrationid7->save();

				$birthweight7 = new AnimalProperty;
				$birthweight7->animal_id = $sow7->id;
				$birthweight7->property_id = $individual5->id;
				$birthweight7->value = "";
				$birthweight7->save();

				$dateweaned7 = new AnimalProperty;
				$dateweaned7->animal_id = $sow7->id;
				$dateweaned7->property_id = $individual6->id;
				$dateweaned7->value = "Not specified";
				$dateweaned7->save();

				$weaningweight7 = new AnimalProperty;
				$weaningweight7->animal_id = $sow7->id;
				$weaningweight7->property_id = $individual7->id;
				$weaningweight7->value = "";
				$weaningweight7->save();

				$dam7 = new AnimalProperty;
				$dam7->animal_id = $sow7->id;
				$dam7->property_id = $individual8->id;
				$dam7->value = "Not specified";
				$dam7->save();

				$sire7 = new AnimalProperty;
				$sire7->animal_id = $sow7->id;
				$sire7->property_id = $individual9->id;
				$sire7->value = "Not specified";
				$sire7->save();

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

				$earnotch8 = new AnimalProperty;
				$earnotch8->animal_id = $sow8->id;
				$earnotch8->property_id = $individual1->id;
				$earnotch8->value = "001-36";
				$earnotch8->save();

				$sex8 = new AnimalProperty;
				$sex8->animal_id = $sow8->id;
				$sex8->property_id = $individual2->id;
				$sex8->value = "F";
				$sex8->save();

				$datefarrowed8 = new AnimalProperty;
				$datefarrowed8->animal_id = $sow8->id;
				$datefarrowed8->property_id = $individual3->id;
				$datefarrowed8->value = "Not specified";
				$datefarrowed8->save();

				$registrationid8 = new AnimalProperty;
				$registrationid8->animal_id = $sow8->id;
				$registrationid8->property_id = $individual4->id;
				$registrationid8->value = $msc->code.$marinduke->breed.'-'.$sex8->value.$earnotch8->value;
				$registrationid8->save();

				$birthweight8 = new AnimalProperty;
				$birthweight8->animal_id = $sow8->id;
				$birthweight8->property_id = $individual5->id;
				$birthweight8->value = "";
				$birthweight8->save();

				$dateweaned8 = new AnimalProperty;
				$dateweaned8->animal_id = $sow8->id;
				$dateweaned8->property_id = $individual6->id;
				$dateweaned8->value = "Not specified";
				$dateweaned8->save();

				$weaningweight8 = new AnimalProperty;
				$weaningweight8->animal_id = $sow8->id;
				$weaningweight8->property_id = $individual7->id;
				$weaningweight8->value = "";
				$weaningweight8->save();

				$dam8 = new AnimalProperty;
				$dam8->animal_id = $sow8->id;
				$dam8->property_id = $individual8->id;
				$dam8->value = "Not specified";
				$dam8->save();

				$sire8 = new AnimalProperty;
				$sire8->animal_id = $sow8->id;
				$sire8->property_id = $individual9->id;
				$sire8->value = "Not specified";
				$sire8->save();

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

				$earnotch9 = new AnimalProperty;
				$earnotch9->animal_id = $sow9->id;
				$earnotch9->property_id = $individual1->id;
				$earnotch9->value = "0007-4";
				$earnotch9->save();

				$sex9 = new AnimalProperty;
				$sex9->animal_id = $sow9->id;
				$sex9->property_id = $individual2->id;
				$sex9->value = "F";
				$sex9->save();

				$datefarrowed9 = new AnimalProperty;
				$datefarrowed9->animal_id = $sow9->id;
				$datefarrowed9->property_id = $individual3->id;
				$datefarrowed9->value = "Not specified";
				$datefarrowed9->save();

				$registrationid9 = new AnimalProperty;
				$registrationid9->animal_id = $sow9->id;
				$registrationid9->property_id = $individual4->id;
				$registrationid9->value = $msc->code.$marinduke->breed.'-'.$sex9->value.$earnotch9->value;
				$registrationid9->save();

				$birthweight9 = new AnimalProperty;
				$birthweight9->animal_id = $sow9->id;
				$birthweight9->property_id = $individual5->id;
				$birthweight9->value = "";
				$birthweight9->save();

				$dateweaned9 = new AnimalProperty;
				$dateweaned9->animal_id = $sow9->id;
				$dateweaned9->property_id = $individual6->id;
				$dateweaned9->value = "Not specified";
				$dateweaned9->save();

				$weaningweight9 = new AnimalProperty;
				$weaningweight9->animal_id = $sow9->id;
				$weaningweight9->property_id = $individual7->id;
				$weaningweight9->value = "";
				$weaningweight9->save();

				$dam9 = new AnimalProperty;
				$dam9->animal_id = $sow9->id;
				$dam9->property_id = $individual8->id;
				$dam9->value = "Not specified";
				$dam9->save();

				$sire9 = new AnimalProperty;
				$sire9->animal_id = $sow9->id;
				$sire9->property_id = $individual9->id;
				$sire9->value = "Not specified";
				$sire9->save();

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

				$earnotch10 = new AnimalProperty;
				$earnotch10->animal_id = $sow10->id;
				$earnotch10->property_id = $individual1->id;
				$earnotch10->value = "0001-1";
				$earnotch10->save();

				$sex10 = new AnimalProperty;
				$sex10->animal_id = $sow10->id;
				$sex10->property_id = $individual2->id;
				$sex10->value = "F";
				$sex10->save();

				$datefarrowed10 = new AnimalProperty;
				$datefarrowed10->animal_id = $sow10->id;
				$datefarrowed10->property_id = $individual3->id;
				$datefarrowed10->value = "Not specified";
				$datefarrowed10->save();

				$registrationid10 = new AnimalProperty;
				$registrationid10->animal_id = $sow10->id;
				$registrationid10->property_id = $individual4->id;
				$registrationid10->value = $msc->code.$marinduke->breed.'-'.$sex10->value.$earnotch10->value;
				$registrationid10->save();

				$birthweight10 = new AnimalProperty;
				$birthweight10->animal_id = $sow10->id;
				$birthweight10->property_id = $individual5->id;
				$birthweight10->value = "";
				$birthweight10->save();

				$dateweaned10 = new AnimalProperty;
				$dateweaned10->animal_id = $sow10->id;
				$dateweaned10->property_id = $individual6->id;
				$dateweaned10->value = "Not specified";
				$dateweaned10->save();

				$weaningweight10 = new AnimalProperty;
				$weaningweight10->animal_id = $sow10->id;
				$weaningweight10->property_id = $individual7->id;
				$weaningweight10->value = "";
				$weaningweight10->save();

				$dam10 = new AnimalProperty;
				$dam10->animal_id = $sow10->id;
				$dam10->property_id = $individual8->id;
				$dam10->value = "Not specified";
				$dam10->save();

				$sire10 = new AnimalProperty;
				$sire10->animal_id = $sow10->id;
				$sire10->property_id = $individual9->id;
				$sire10->value = "Not specified";
				$sire10->save();

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

				$earnotch11 = new AnimalProperty;
				$earnotch11->animal_id = $sow11->id;
				$earnotch11->property_id = $individual1->id;
				$earnotch11->value = "001-34";
				$earnotch11->save();

				$sex11 = new AnimalProperty;
				$sex11->animal_id = $sow11->id;
				$sex11->property_id = $individual2->id;
				$sex11->value = "F";
				$sex11->save();

				$datefarrowed11 = new AnimalProperty;
				$datefarrowed11->animal_id = $sow11->id;
				$datefarrowed11->property_id = $individual3->id;
				$datefarrowed11->value = "Not specified";
				$datefarrowed11->save();

				$registrationid11 = new AnimalProperty;
				$registrationid11->animal_id = $sow11->id;
				$registrationid11->property_id = $individual4->id;
				$registrationid11->value = $msc->code.$marinduke->breed.'-'.$sex11->value.$earnotch11->value;
				$registrationid11->save();

				$birthweight11 = new AnimalProperty;
				$birthweight11->animal_id = $sow11->id;
				$birthweight11->property_id = $individual5->id;
				$birthweight11->value = "";
				$birthweight11->save();

				$dateweaned11 = new AnimalProperty;
				$dateweaned11->animal_id = $sow11->id;
				$dateweaned11->property_id = $individual6->id;
				$dateweaned11->value = "Not specified";
				$dateweaned11->save();

				$weaningweight11 = new AnimalProperty;
				$weaningweight11->animal_id = $sow11->id;
				$weaningweight11->property_id = $individual7->id;
				$weaningweight11->value = "";
				$weaningweight11->save();

				$dam11 = new AnimalProperty;
				$dam11->animal_id = $sow11->id;
				$dam11->property_id = $individual8->id;
				$dam11->value = "Not specified";
				$dam11->save();

				$sire11 = new AnimalProperty;
				$sire11->animal_id = $sow11->id;
				$sire11->property_id = $individual9->id;
				$sire11->value = "Not specified";
				$sire11->save();

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

				$earnotch12 = new AnimalProperty;
				$earnotch12->animal_id = $sow12->id;
				$earnotch12->property_id = $individual1->id;
				$earnotch12->value = "000006";
				$earnotch12->save();

				$sex12 = new AnimalProperty;
				$sex12->animal_id = $sow12->id;
				$sex12->property_id = $individual2->id;
				$sex12->value = "F";
				$sex12->save();

				$datefarrowed12 = new AnimalProperty;
				$datefarrowed12->animal_id = $sow12->id;
				$datefarrowed12->property_id = $individual3->id;
				$datefarrowed12->value = "Not specified";
				$datefarrowed12->save();

				$registrationid12 = new AnimalProperty;
				$registrationid12->animal_id = $sow12->id;
				$registrationid12->property_id = $individual4->id;
				$registrationid12->value = $msc->code.$marinduke->breed.'-'.$sex12->value.$earnotch12->value;
				$registrationid12->save();

				$birthweight12 = new AnimalProperty;
				$birthweight12->animal_id = $sow12->id;
				$birthweight12->property_id = $individual5->id;
				$birthweight12->value = "";
				$birthweight12->save();

				$dateweaned12 = new AnimalProperty;
				$dateweaned12->animal_id = $sow12->id;
				$dateweaned12->property_id = $individual6->id;
				$dateweaned12->value = "Not specified";
				$dateweaned12->save();

				$weaningweight12 = new AnimalProperty;
				$weaningweight12->animal_id = $sow12->id;
				$weaningweight12->property_id = $individual7->id;
				$weaningweight12->value = "";
				$weaningweight12->save();

				$dam12 = new AnimalProperty;
				$dam12->animal_id = $sow12->id;
				$dam12->property_id = $individual8->id;
				$dam12->value = "Not specified";
				$dam12->save();

				$sire12 = new AnimalProperty;
				$sire12->animal_id = $sow12->id;
				$sire12->property_id = $individual9->id;
				$sire12->value = "Not specified";
				$sire12->save();

				$this->command->info('AnimalProperty seeded');

				$sow12->registryid = $registrationid12->value;
				$sow12->save();
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

				$earnotch13 = new AnimalProperty;
				$earnotch13->animal_id = $boar1->id;
				$earnotch13->property_id = $individual1->id;
				$earnotch13->value = "000005";
				$earnotch13->save();

				$sex13 = new AnimalProperty;
				$sex13->animal_id = $boar1->id;
				$sex13->property_id = $individual2->id;
				$sex13->value = "M";
				$sex13->save();

				$datefarrowed13 = new AnimalProperty;
				$datefarrowed13->animal_id = $boar1->id;
				$datefarrowed13->property_id = $individual3->id;
				$datefarrowed13->value = "Not specified";
				$datefarrowed13->save();

				$registrationid13 = new AnimalProperty;
				$registrationid13->animal_id = $boar1->id;
				$registrationid13->property_id = $individual4->id;
				$registrationid13->value = $msc->code.$marinduke->breed.'-'.$sex13->value.$earnotch13->value;
				$registrationid13->save();

				$birthweight13 = new AnimalProperty;
				$birthweight13->animal_id = $boar1->id;
				$birthweight13->property_id = $individual5->id;
				$birthweight13->value = "";
				$birthweight13->save();

				$dateweaned13 = new AnimalProperty;
				$dateweaned13->animal_id = $boar1->id;
				$dateweaned13->property_id = $individual6->id;
				$dateweaned13->value = "Not specified";
				$dateweaned13->save();

				$weaningweight13 = new AnimalProperty;
				$weaningweight13->animal_id = $boar1->id;
				$weaningweight13->property_id = $individual7->id;
				$weaningweight13->value = "";
				$weaningweight13->save();

				$dam13 = new AnimalProperty;
				$dam13->animal_id = $boar1->id;
				$dam13->property_id = $individual8->id;
				$dam13->value = "Not specified";
				$dam13->save();

				$sire13 = new AnimalProperty;
				$sire13->animal_id = $boar1->id;
				$sire13->property_id = $individual9->id;
				$sire13->value = "Not specified";
				$sire13->save();

				$this->command->info('AnimalProperty seeded');

				$boar1->registryid = $registrationid13->value;
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

				$earnotch14 = new AnimalProperty;
				$earnotch14->animal_id = $boar2->id;
				$earnotch14->property_id = $individual1->id;
				$earnotch14->value = "000008";
				$earnotch14->save();

				$sex14 = new AnimalProperty;
				$sex14->animal_id = $boar2->id;
				$sex14->property_id = $individual2->id;
				$sex14->value = "M";
				$sex14->save();

				$datefarrowed14 = new AnimalProperty;
				$datefarrowed14->animal_id = $boar2->id;
				$datefarrowed14->property_id = $individual3->id;
				$datefarrowed14->value = "Not specified";
				$datefarrowed14->save();

				$registrationid14 = new AnimalProperty;
				$registrationid14->animal_id = $boar2->id;
				$registrationid14->property_id = $individual4->id;
				$registrationid14->value = $msc->code.$marinduke->breed.'-'.$sex14->value.$earnotch14->value;
				$registrationid14->save();

				$birthweight14 = new AnimalProperty;
				$birthweight14->animal_id = $boar2->id;
				$birthweight14->property_id = $individual5->id;
				$birthweight14->value = "";
				$birthweight14->save();

				$dateweaned14 = new AnimalProperty;
				$dateweaned14->animal_id = $boar2->id;
				$dateweaned14->property_id = $individual6->id;
				$dateweaned14->value = "Not specified";
				$dateweaned14->save();

				$weaningweight14 = new AnimalProperty;
				$weaningweight14->animal_id = $boar2->id;
				$weaningweight14->property_id = $individual7->id;
				$weaningweight14->value = "";
				$weaningweight14->save();

				$dam14 = new AnimalProperty;
				$dam14->animal_id = $boar2->id;
				$dam14->property_id = $individual8->id;
				$dam14->value = "Not specified";
				$dam14->save();

				$sire14 = new AnimalProperty;
				$sire14->animal_id = $boar2->id;
				$sire14->property_id = $individual9->id;
				$sire14->value = "Not specified";
				$sire14->save();

				$this->command->info('AnimalProperty seeded');

				$boar2->registryid = $registrationid14->value;
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

				$earnotch15 = new AnimalProperty;
				$earnotch15->animal_id = $boar3->id;
				$earnotch15->property_id = $individual1->id;
				$earnotch15->value = "000001";
				$earnotch15->save();

				$sex15 = new AnimalProperty;
				$sex15->animal_id = $boar3->id;
				$sex15->property_id = $individual2->id;
				$sex15->value = "M";
				$sex15->save();

				$datefarrowed15 = new AnimalProperty;
				$datefarrowed15->animal_id = $boar3->id;
				$datefarrowed15->property_id = $individual3->id;
				$datefarrowed15->value = "Not specified";
				$datefarrowed15->save();

				$registrationid15 = new AnimalProperty;
				$registrationid15->animal_id = $boar3->id;
				$registrationid15->property_id = $individual4->id;
				$registrationid15->value = $msc->code.$marinduke->breed.'-'.$sex15->value.$earnotch15->value;
				$registrationid15->save();

				$birthweight15 = new AnimalProperty;
				$birthweight15->animal_id = $boar3->id;
				$birthweight15->property_id = $individual5->id;
				$birthweight15->value = "";
				$birthweight15->save();

				$dateweaned15 = new AnimalProperty;
				$dateweaned15->animal_id = $boar3->id;
				$dateweaned15->property_id = $individual6->id;
				$dateweaned15->value = "Not specified";
				$dateweaned15->save();

				$weaningweight15 = new AnimalProperty;
				$weaningweight15->animal_id = $boar3->id;
				$weaningweight15->property_id = $individual7->id;
				$weaningweight15->value = "";
				$weaningweight15->save();

				$dam15 = new AnimalProperty;
				$dam15->animal_id = $boar3->id;
				$dam15->property_id = $individual8->id;
				$dam15->value = "Not specified";
				$dam15->save();

				$sire15 = new AnimalProperty;
				$sire15->animal_id = $boar3->id;
				$sire15->property_id = $individual9->id;
				$sire15->value = "Not specified";
				$sire15->save();

				$this->command->info('AnimalProperty seeded');

				$boar3->registryid = $registrationid15->value;
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

				$earnotch16 = new AnimalProperty;
				$earnotch16->animal_id = $boar4->id;
				$earnotch16->property_id = $individual1->id;
				$earnotch16->value = "0008-7";
				$earnotch16->save();

				$sex16 = new AnimalProperty;
				$sex16->animal_id = $boar4->id;
				$sex16->property_id = $individual2->id;
				$sex16->value = "M";
				$sex16->save();

				$datefarrowed16 = new AnimalProperty;
				$datefarrowed16->animal_id = $boar4->id;
				$datefarrowed16->property_id = $individual3->id;
				$datefarrowed16->value = "Not specified";
				$datefarrowed16->save();

				$registrationid16 = new AnimalProperty;
				$registrationid16->animal_id = $boar4->id;
				$registrationid16->property_id = $individual4->id;
				$registrationid16->value = $msc->code.$marinduke->breed.'-'.$sex16->value.$earnotch16->value;
				$registrationid16->save();

				$birthweight16 = new AnimalProperty;
				$birthweight16->animal_id = $boar4->id;
				$birthweight16->property_id = $individual5->id;
				$birthweight16->value = "";
				$birthweight16->save();

				$dateweaned16 = new AnimalProperty;
				$dateweaned16->animal_id = $boar4->id;
				$dateweaned16->property_id = $individual6->id;
				$dateweaned16->value = "Not specified";
				$dateweaned16->save();

				$weaningweight16 = new AnimalProperty;
				$weaningweight16->animal_id = $boar4->id;
				$weaningweight16->property_id = $individual7->id;
				$weaningweight16->value = "";
				$weaningweight16->save();

				$dam16 = new AnimalProperty;
				$dam16->animal_id = $boar4->id;
				$dam16->property_id = $individual8->id;
				$dam16->value = "Not specified";
				$dam16->save();

				$sire16 = new AnimalProperty;
				$sire16->animal_id = $boar4->id;
				$sire16->property_id = $individual9->id;
				$sire16->value = "Not specified";
				$sire16->save();

				$this->command->info('AnimalProperty seeded');

				$boar4->registryid = $registrationid16->value;
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

				$earnotch17 = new AnimalProperty;
				$earnotch17->animal_id = $boar5->id;
				$earnotch17->property_id = $individual1->id;
				$earnotch17->value = "0001-7";
				$earnotch17->save();

				$sex17 = new AnimalProperty;
				$sex17->animal_id = $boar5->id;
				$sex17->property_id = $individual2->id;
				$sex17->value = "M";
				$sex17->save();

				$datefarrowed17 = new AnimalProperty;
				$datefarrowed17->animal_id = $boar5->id;
				$datefarrowed17->property_id = $individual3->id;
				$datefarrowed17->value = "Not specified";
				$datefarrowed17->save();

				$registrationid17 = new AnimalProperty;
				$registrationid17->animal_id = $boar5->id;
				$registrationid17->property_id = $individual4->id;
				$registrationid17->value = $msc->code.$marinduke->breed.'-'.$sex17->value.$earnotch17->value;
				$registrationid17->save();

				$birthweight17 = new AnimalProperty;
				$birthweight17->animal_id = $boar5->id;
				$birthweight17->property_id = $individual5->id;
				$birthweight17->value = "";
				$birthweight17->save();

				$dateweaned17 = new AnimalProperty;
				$dateweaned17->animal_id = $boar5->id;
				$dateweaned17->property_id = $individual6->id;
				$dateweaned17->value = "Not specified";
				$dateweaned17->save();

				$weaningweight17 = new AnimalProperty;
				$weaningweight17->animal_id = $boar5->id;
				$weaningweight17->property_id = $individual7->id;
				$weaningweight17->value = "";
				$weaningweight17->save();

				$dam17 = new AnimalProperty;
				$dam17->animal_id = $boar5->id;
				$dam17->property_id = $individual8->id;
				$dam17->value = "Not specified";
				$dam17->save();

				$sire17 = new AnimalProperty;
				$sire17->animal_id = $boar5->id;
				$sire17->property_id = $individual9->id;
				$sire17->value = "Not specified";
				$sire17->save();

				$this->command->info('AnimalProperty seeded');

				$boar5->registryid = $registrationid17->value;
				$boar5->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$boar6 = new Animal;
				$msc->animaltypes()->attach($pig->id);
				$boar6->animaltype_id = $pig->id;
				$boar6->farm_id = $msc->id;
				$boar6->breed_id = $marinduke->id;
				$boar6->status = "breeder";
				$boar6->save();
				$this->command->info('Animal seeded');

				$earnotch18 = new AnimalProperty;
				$earnotch18->animal_id = $boar6->id;
				$earnotch18->property_id = $individual1->id;
				$earnotch18->value = "000023";
				$earnotch18->save();

				$sex18 = new AnimalProperty;
				$sex18->animal_id = $boar6->id;
				$sex18->property_id = $individual2->id;
				$sex18->value = "M";
				$sex18->save();

				$datefarrowed18 = new AnimalProperty;
				$datefarrowed18->animal_id = $boar6->id;
				$datefarrowed18->property_id = $individual3->id;
				$datefarrowed18->value = "Not specified";
				$datefarrowed18->save();

				$registrationid18 = new AnimalProperty;
				$registrationid18->animal_id = $boar6->id;
				$registrationid18->property_id = $individual4->id;
				$registrationid18->value = $msc->code.$marinduke->breed.'-'.$sex18->value.$earnotch18->value;
				$registrationid18->save();

				$birthweight18 = new AnimalProperty;
				$birthweight18->animal_id = $boar6->id;
				$birthweight18->property_id = $individual5->id;
				$birthweight18->value = "";
				$birthweight18->save();

				$dateweaned18 = new AnimalProperty;
				$dateweaned18->animal_id = $boar6->id;
				$dateweaned18->property_id = $individual6->id;
				$dateweaned18->value = "Not specified";
				$dateweaned18->save();

				$weaningweight18 = new AnimalProperty;
				$weaningweight18->animal_id = $boar6->id;
				$weaningweight18->property_id = $individual7->id;
				$weaningweight18->value = "";
				$weaningweight18->save();

				$dam18 = new AnimalProperty;
				$dam18->animal_id = $boar6->id;
				$dam18->property_id = $individual8->id;
				$dam18->value = "Not specified";
				$dam18->save();

				$sire18 = new AnimalProperty;
				$sire18->animal_id = $boar6->id;
				$sire18->property_id = $individual9->id;
				$sire18->value = "Not specified";
				$sire18->save();

				$this->command->info('AnimalProperty seeded');

				$boar6->registryid = $registrationid18->value;
				$boar6->save();
				$this->command->info('Registry ID added to animal');

				/***/

				$this->command->info('Initial data seeded');

		}

}
