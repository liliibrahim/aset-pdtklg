<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string $module
 * @property int|null $record_id
 * @property array<array-key, mixed>|null $payload
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUserId($value)
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $no_peralatan
 * @property string|null $no_aset_dalaman
 * @property string $nama
 * @property string|null $jenama
 * @property string|null $model
 * @property string|null $kategori
 * @property string|null $tahun_perolehan
 * @property string|null $harga
 * @property string $sumber
 * @property int|null $pembekal_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Placement|null $activePlacement
 * @property-read \App\Models\Disposal|null $disposal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Maintenance> $maintenances
 * @property-read int|null $maintenances_count
 * @property-read \App\Models\Supplier|null $pembekal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Placement> $placements
 * @property-read int|null $placements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereJenama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereNoAsetDalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereNoPeralatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset wherePembekalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereSumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereTahunPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereUpdatedAt($value)
 */
	class Asset extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $units
 * @property-read int|null $units_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahagian whereUpdatedAt($value)
 */
	class Bahagian extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $asset_id
 * @property string $tarikh
 * @property string $sebab
 * @property string|null $kaedah
 * @property string|null $rujukan_kelulusan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereKaedah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereRujukanKelulusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereSebab($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereTarikh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Disposal whereUpdatedAt($value)
 */
	class Disposal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Bahagian|null $bahagian
 * @property-read \App\Models\Unit|null $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi query()
 */
	class Lokasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $asset_id
 * @property string $tarikh
 * @property string $jenis_kerja
 * @property string|null $kos
 * @property string|null $catatan
 * @property int|null $pembekal_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\Supplier|null $pembekal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereJenisKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereKos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance wherePembekalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereTarikh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maintenance whereUpdatedAt($value)
 */
	class Maintenance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $asset_id
 * @property int|null $user_id
 * @property int|null $bahagian_id
 * @property int|null $unit_id
 * @property string $tarikh_mula
 * @property string|null $tarikh_tamat
 * @property int $aktif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\Bahagian|null $bahagian
 * @property-read \App\Models\Unit|null $unit
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereBahagianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereTarikhMula($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereTarikhTamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Placement whereUserId($value)
 */
	class Placement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string|null $no_telefon
 * @property string|null $emel
 * @property string|null $alamat
 * @property int $aktif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $assets
 * @property-read int|null $assets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereNoTelefon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $bahagian_id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bahagian $bahagian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereBahagianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereUpdatedAt($value)
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $phone
 * @property int|null $bahagian_id
 * @property int|null $unit_id
 * @property string $role
 * @property-read \App\Models\Bahagian|null $bahagian
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Unit|null $unit
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBahagianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

