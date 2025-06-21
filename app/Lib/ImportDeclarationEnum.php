<?php

namespace App\Lib;

class ImportDeclarationEnum
{

    public static $declType = [
        [
            "code" => "CO",
            "name" => "CO",
            "key" => "1"
        ], [
            "code" => "IM",
            "name" => "IM",
            "key" => "2"
        ]
    ];

    public static $declarationType = [
        [
            "code" => "A",
            "name" => "Standard declaration",
            "key" => "1"
        ],
        [
            "code" => "B",
            "name" => "Simplified declaration",
            "key" => "2"
        ],
        [
            "code" => "D",
            "name" => "Normal pre-declaration",
            "key" => "3"
        ],
        [
            "code" => "X",
            "name" => "Supplementary declaration (to B and E)",
            "key" => "4"
        ],
        [
            "code" => "Z",
            "name" => "Supplementary declaration (entry in records)",
            "key" => "5"
        ]
    ];

    public static $procedureType = [
        [
            "code" => "H1",
            "name" => "Declaration for release for free circulation and special procedure - specific use - declaration for end-use",
            "key" => "11"
        ],
        [
            "code" => "H2",
            "name" => "Special procedure - storage - declaration for customs warehousing",
            "key" => "12"
        ],
        [
            "code" => "H3",
            "name" => "Special procedure - specific use - declaration for temporary admission",
            "key" => "13"
        ],
        [
            "code" => "H4",
            "name" => "Special procedure - processing - declaration for inward processing",
            "key" => "14"
        ],
        [
            "code" => "H5",
            "name" => "Declaration for the introduction of goods in the context of trade with special fiscal territories",
            "key" => "15"
        ],
        [
            "code" => "H6",
            "name" => "Customs declaration in postal traffic for release for free circulation",
            "key" => "16"
        ],
        [
            "code" => "H7",
            "name" => "Customs declaration for release for free circulation in respect of a consignment which benefits from a relief from import duty in accordance with Article 23(1) or Article 25(1) of Regulation (EC) No 1186/2009",
            "key" => "17"
        ],
        [
            "code" => "I1",
            "name" => "Import simplified declaration",
            "key" => "18"
        ],
        [
            "code" => "I2A",
            "name" => "Presentation of goods to customs in case of entry in the declarant's records or in the context of customs declarations lodged prior to the presentation of the goods at import (Minimal Dataset)",
            "key" => "19"
        ],
        [
            "code" => "I2B",
            "name" => "Presentation of goods to customs in case of entry in the declarant's records or in the context of customs declarations lodged prior to the presentation of the goods at import (Maximum Dataset)",
            "key" => "20"
        ]
    ];

    public static $representation = [
        [
            "code" => "1",
            "name" => "No representation",
            "key" => "1"
        ],
        [
            "code" => "2",
            "name" => "Vertegenwoordiger (directe vertegenwoordiging in de zin van artikel 18, lid 1, van het wetboek)",
            "key" => "2"
        ],
        [
            "code" => "3",
            "name" => "Vertegenwoordiger (indirecte vertegenwoordiging in de zin van artikel 18, lid 1, van het wetboek)",
            "key" => "3"
        ]
    ];

    public static $goodsLocationType = [
        [
            "code" => "A",
            "name" => "Aangewezen plaats",
            "key" => "1"
        ],
        [
            "code" => "B",
            "name" => "Erkende plaats",
            "key" => "2"
        ],
        [
            "code" => "C",
            "name" => "Goedgekeurde plaats",
            "key" => "3"
        ],
        [
            "code" => "D",
            "name" => "Andere",
            "key" => "4"
        ]
    ];

    public static $goodsLocationQualifier = [
        [
            "code" => "T",
            "name" => "Postal code",
            "key" => "1"
        ],
        [
            "code" => "U",
            "name" => "UN/LOCODE",
            "key" => "2"
        ],
        [
            "code" => "V",
            "name" => "Customs office identifier",
            "key" => "3"
        ],
        [
            "code" => "W",
            "name" => "GNSS coordinates",
            "key" => "4"
        ],
        [
            "code" => "X",
            "name" => "EORI number",
            "key" => "5"
        ],
        [
            "code" => "Y",
            "name" => "Authorisation number",
            "key" => "6"
        ],
        [
            "code" => "Z",
            "name" => "Free text",
            "key" => "7"
        ]
    ];

    public static $transportModeBorder = [
        [
            "code" => "1",
            "name" => "Sea transport",
            "key" => "1"
        ],
        [
            "code" => "2",
            "name" => "Rail transport",
            "key" => "2"
        ],
        [
            "code" => "3",
            "name" => "Road transport",
            "key" => "3"
        ],
        [
            "code" => "4",
            "name" => "Air transport",
            "key" => "4"
        ],
        [
            "code" => "5",
            "name" => "Postal consignment",
            "key" => "5"
        ],
        [
            "code" => "7",
            "name" => "Fixed transport installations",
            "key" => "6"
        ],
        [
            "code" => "8",
            "name" => "Inland waterway transport",
            "key" => "7"
        ],
        [
            "code" => "9",
            "name" => "Own propulsion",
            "key" => "8"
        ]
    ];

    public static $transportMeansTypeArrival = [
        [
            "code" => "10",
            "name" => "IMO-scheepsidentificatiednummer",
            "key" => "1"
        ],
        [
            "code" => "11",
            "name" => "Naam van het zeeschip",
            "key" => "2"
        ],
        [
            "code" => "20",
            "name" => "Nummer van de wagon",
            "key" => "3"
        ],
        [
            "code" => "21",
            "name" => "Treinnummer",
            "key" => "4"
        ],
        [
            "code" => "30",
            "name" => "Kenteken van het wegvoertuig",
            "key" => "5"
        ],
        [
            "code" => "31",
            "name" => "Kenteken van de aanhangwagen (wegvervoer)",
            "key" => "6"
        ],
        [
            "code" => "40",
            "name" => "IATA-vluchtnummer",
            "key" => "7"
        ],
        [
            "code" => "41",
            "name" => "Registratienummer van het luchtvaartuig",
            "key" => "8"
        ],
        [
            "code" => "80",
            "name" => "Europees Scheepsidentificatiednummer (ENI-code)",
            "key" => "9"
        ],
        [
            "code" => "81",
            "name" => "Naam van het binnenschip",
            "key" => "10"
        ]
    ];
}
