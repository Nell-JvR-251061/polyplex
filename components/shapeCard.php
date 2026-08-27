<?php
// Prevents IDE from flagging variables as undefined
/** @var int|string $shapeId */
/** @var string $shapeDB */
/** @var string $fillColour */
/** @var string $strokeColour */
/** @var int|string $shapeLevel */
/** @var string $abilityName */
/** @var string $abilityDescription */
/** @var string $abilityModifier */
/** @var string $abilityTarget */

//added some fallback values in case an error occurs 
$shapeId = $shapeId ?? '';
$shapeDB = strtolower(trim($shapeDB ?? ''));

$fillColour = $fillColour ?? '#FFFFFF';
$strokeColour = $strokeColour ?? '#000000';

$shapeLevel = $shapeLevel ?? 1;

$abilityName = $abilityName ?? 'None';
$abilityDescription = $abilityDescription ?? '';
$abilityModifier = $abilityModifier ?? '+';
$abilityTarget = $abilityTarget ?? 'self';

switch ($shapeDB) { //using SVGs to represent the shape, storing their corresponding nodes/points
    case 'circle':
        $points = "12,2 14.59,2.34 17,3.34 18.66,5 20,7 21,9.41 21.66,12 21,14.59 20,17 18.66,19 17,20.66 14.59,21.66 12,22 9.41,21.66 7,20.66 5.34,19 4,17 3,14.59 2.34,12 3,9.41 4,7 5.34,5 7,3.34 9.41,2.34";
        break;

    case 'triangle':
        $points = "12,2 22,22 2,22";
        break;

    case 'square':
        $points = "2,2 22,2 22,22 2,22";
        break;

    case 'pentagon':
        $points = "12,2 21.51,8.91 17.88,20.09 6.12,20.09 2.49,8.91";
        break;

    case 'hexagon':
        $points = "12,2 20.66,7 20.66,17 12,22 3.34,17 3.34,7";
        break;

    default:
        $points = "2,2 22,2 22,22 2,22";
        break;
}
?>

<div class="container-fluid shape-card ubuntu-bold text-center p-2 fs-5">

    <div class="row shape-id p-1"> <!-- displays shape id -->
        <span>
            # <?= htmlspecialchars((string) $shapeId) ?>
        </span>
    </div>

    <div class="row shape-in-card d-flex justify-content-center"> <!--displays shape-->
        <svg
            class="shape"
            viewBox="0 0 24 24"
            aria-label="<?= htmlspecialchars($shapeDB) ?>">
            //enum value used here
            <polygon 
                points="<?= htmlspecialchars($points) ?>" 
                fill="<?= htmlspecialchars($fillColour) ?>"
                stroke="<?= htmlspecialchars($strokeColour) ?>"
                stroke-width="2" />

        </svg>
    </div>

    <div class="row shape-level p-1"> <!--displays shape's level-->
        <span>
            Level <?= htmlspecialchars((string) $shapeLevel) ?>
        </span>
    </div>

    <div class="row shape-abilities-title"> <!--displays shape's ability's name-->
        <span>Ability</span>
    </div>

    <div class="row shape-abilities inter-regular fs-6">
        <span>
            <?= htmlspecialchars($abilityName) ?>
        </span>
    </div>
</div>
