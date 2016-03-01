<?php
/* @var $this BiobankController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php Yii::app()->clientScript->registerCss('mapCss', '
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 675px;
      }

');
?>
<h1><?php echo Yii::t('common', 'Map of biobanks') ?></h1>
<div id="map"></div>
<div id="initScript">
    <script >

        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6
            });
            var country = "France";
            var geocoder;
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': country}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                }
            }
            );

<?php
//$criteria->limit(15);
$localCriteria = new EMongoCriteria;
$localCriteria->addCond('location', 'exists', true);
$localCriteria->select(array('location', 'identifier'));
$biobanks = Biobank::model()->findAll($localCriteria);
//$biobanks = $dataProvider->data;

$i = 0;
foreach ($biobanks as $biobank) {
    if (isset($biobank->location)) {

        $i++;
        echo "var marker$i = new google.maps.Marker({
                       position: {lat: " . str_ireplace(',', '.', $biobank->location['coordinates'][1]) . ", lng:" . str_ireplace(',', '.', $biobank->location['coordinates'][0]) . "},
                       map: map,
                        title: '" . str_ireplace("'", "\'", $biobank->name) . "'
                    });";
    }
}
?>
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo CommonProperties::$GMAPS_KEY; ?>&callback=initMap"
    async defer></script>
</div>
