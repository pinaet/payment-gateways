<?php

use Illuminate\Database\Seeder;

use App\Endpoint;

class EndpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Endpoint::truncate();

        if( config('gate.mode')=='gate-dev' )
        {
            //id=1
            $attributes['endpoint_type_id'] = 2;//form
            $attributes['name']             = 'Summer Programmes';
            $attributes['description']      = 'Summer Holiday Programmes';
            $attributes['endpoint_url']     = 'https://applications.harrowschool.ac.th/uat-naet/SummerProgram/';
            $attributes['notify_url']       = 'https://applications.harrowschool.ac.th/uat-naet/SummerProgram/order-notify.php';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th';
            $attributes['footnote']         = 'We have received your payment of Summer Programme.<br>* Should you have any urgent requests please contact holidayprogrammes@harrowschool.ac.th';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://histest.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            
            Endpoint::create( $attributes );

            //id=2
            $attributes['endpoint_type_id'] = 1;//school
            $attributes['name']             = 'Tuition Fee';
            $attributes['description']      = 'Tuition Fee';
            $attributes['endpoint_url']     = 'https://histest.harrowschool.ac.th/ticket/public/school-fee';
            $attributes['notify_url']       = 'https://histest.harrowschool.ac.th/ticket/public/school-fee/order-notify';
            $attributes['bcc']              = 'pinaet@hotmail.com,pinaet@gmail.com';
            $attributes['footnote']         = '';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://histest.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );
            
            //id=3
            $attributes['endpoint_type_id'] = 2;//form
            $attributes['name']             = 'Application Fee';
            $attributes['description']      = 'Admission Application Fee';
            $attributes['endpoint_url']     = 'https://histest.harrowschool.ac.th/ticket/public/application-fee/';
            $attributes['notify_url']       = 'https://histest.harrowschool.ac.th/ticket/public/application-fee/order-notify';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th';
            $attributes['footnote']         = 'We have received your payment of Application Fee.<br>* Should you have any urgent requests please contact admissions@harrowschool.ac.th';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://histest.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );

            //id=4
            $attributes['endpoint_type_id'] = 2;//form
            $attributes['name']             = 'Christmas Programmes';
            $attributes['description']      = 'Christmas Holiday Programmes';
            $attributes['endpoint_url']     = 'https://histest.harrowschool.ac.th/ChristmasProgramme/';
            $attributes['notify_url']       = 'https://histest.harrowschool.ac.th/ChristmasProgramme/order-notify.php';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th';
            $attributes['footnote']         = 'We have received your payment of Christmas Programme.<br>* Should you have any urgent requests please contact holidayprogrammes@harrowschool.ac.th';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://histest.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );

            //id=5
            $attributes['endpoint_type_id'] = 3;//event
            $attributes['name']             = 'OFFSEAS 2021';
            $attributes['description']      = 'OFFSEAS 2021';
            $attributes['endpoint_url']     = 'https://offseas.squarespace.com/partners';
            $attributes['notify_url']       = 'https://histest.harrowschool.ac.th/ticket/public/event/order-notify';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th';
            $attributes['footnote']         = 'Thank you for your registration for OFFSEAS 2021. Please do not hesitate to contact us at admin@offseas.org should you have any questions prior to the event. We look forward to seeing you in May!';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://histest.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'n';
            Endpoint::create( $attributes );
        }
        else //config('gate.mode')=='gate' production
        {
            //id=1
            $attributes['endpoint_type_id'] = 2;//form
            $attributes['name']             = 'Summer Programmes';
            $attributes['description']      = 'Summer Holiday Programmes';
            $attributes['endpoint_url']     = 'https://applications.harrowschool.ac.th/SummerProgramme/';
            $attributes['notify_url']       = 'https://applications.harrowschool.ac.th/SummerProgramme/order-notify.php';
            $attributes['bcc']              = 'off_ta@harrowschool.ac.th,holidayprogrammes@harrowschool.ac.th,finance@harrowschool.ac.th,shalini_ch@harrowschool.ac.th,grace_se@harrowschool.ac.th,naet_ph@harrowschool.ac.th';
            $attributes['footnote']         = 'We have received your payment of Summer Programme.<br>* Should you have any urgent requests please contact holidayprogrammes@harrowschool.ac.th';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://applications.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );
            
            //id=2
            $attributes['endpoint_type_id'] = 1;//school
            $attributes['name']             = 'Tuition Fee';
            $attributes['description']      = 'Tuition Fee';
            $attributes['endpoint_url']     = 'https://applications.harrowschool.ac.th/ticket/public/school-fee';
            $attributes['notify_url']       = 'https://applications.harrowschool.ac.th/ticket/public/school-fee/order-notify';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th,finance@harrowschool.ac.th';
            $attributes['footnote']         = '';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://applications.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );
            
            //id=3
            $attributes['endpoint_type_id'] = 2;//form
            $attributes['name']             = 'Application Fee';
            $attributes['description']      = 'Admission Application Fee';
            $attributes['endpoint_url']     = 'https://apps.harrowschool.ac.th/ticket/public/application-fee/';
            $attributes['notify_url']       = 'https://apps.harrowschool.ac.th/ticket/public/application-fee/order-notify';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th,admissions@harrowschool.ac.th,finance@harrowschool.ac.th';
            $attributes['footnote']         = 'We have received your payment of Application Fee.<br>* Should you have any urgent requests please contact admissions@harrowschool.ac.th';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://applications.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );

            //id=4
            $attributes['endpoint_type_id'] = 2;//form
            $attributes['name']             = 'Christmas Programmes';
            $attributes['description']      = 'Christmas Holiday Programmes';
            $attributes['endpoint_url']     = 'https://applications.harrowschool.ac.th/ChristmasProgramme/';
            $attributes['notify_url']       = 'https://applications.harrowschool.ac.th/ChristmasProgramme/order-notify.php';
            $attributes['bcc']              = 'shalini_ch@harrowschool.ac.th,naet_ph@harrowschool.ac.th,jon_co@harrowschool.ac.th,finance@harrowschool.ac.th,holidayprogrammes@harrowschool.ac.th,pang_sa@harrowschool.ac.th';
            $attributes['footnote']         = 'We have received your payment of Christmas Programme.<br>* Should you have any urgent requests please contact holidayprogrammes@harrowschool.ac.th';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://applications.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'y';
            Endpoint::create( $attributes );

            //id=5
            $attributes['endpoint_type_id'] = 3;//event
            $attributes['name']             = 'OFFSEAS 2021';
            $attributes['description']      = 'OFFSEAS 2021';
            $attributes['endpoint_url']     = 'https://offseas.squarespace.com/partners';
            $attributes['notify_url']       = 'https://apps.harrowschool.ac.th/ticket/public/event/order-notify';
            $attributes['bcc']              = 'naet_ph@harrowschool.ac.th,liam_wa@harrowschool.ac.th,christina@smartcookies.io,admin@offseas.org,finance@harrowschool.ac.th';
            $attributes['footnote']         = 'Thank you for your registration for OFFSEAS 2021. Please do not hesitate to contact us at admin@offseas.org should you have any questions prior to the event. We look forward to seeing you in May!';
            $attributes['cost_type']        = 'v';
            $attributes['cost_per_unit']    = 1;
            $attributes['pay_url']          = 'https://applications.harrowschool.ac.th/gate/public/order';
            $attributes['charge_fee']       = 'n';
            Endpoint::create( $attributes );
        }
    }
}
