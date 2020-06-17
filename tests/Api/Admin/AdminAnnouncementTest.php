<?php

namespace Tests\Api\Admin;

use Tests\TestCase;
use App\Models\Batch;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAnnouncementTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function adminCanCreateAnnouncements()
    {
        $this->asAdmin();

        $topic = $this->faker->randomElement(['Announcement', 'Updates']);
        $content = $this->faker->sentences(3, true);
        $start_date = $this->faker->dateTimeBetween('now', '+2 day','Asia/Manila')->format('Y-m-d H:i:s');
        $end_date = $this->faker->dateTimeBetween('+2 weeks', '+1 month','Asia/Manila')->format('Y-m-d H:i:s');

        $response = $this->json('POST', route('api.admin.announcement.store', [
            'topic' => $topic,
            'content' => $content,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]));

        $data = $response->getData();

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.announcement.success.store'),
            ]);
    }

    /**
     * @test
     */
    public function adminCanGetAnnouncementList()
    {
        $this->asAdmin();

        $response = $this->json('GET', route('api.admin.announcement'));

        $data = $response->getData();
        $response
           ->assertStatus(self::RESPONSE_SUCCESS)
           ->assertJson([
               'success' => true,
               'message' => '',
           ]);

        $this->assertNotEmpty($data->announcements);
        $this->paginationTest($data->announcements);

        // Check announcements are not similar and group by batch
        $isUniqueBatch = true;
        $batch_ids = [];
        foreach ($data->announcements->data as $announcement) {
            if (in_array($announcement->batch_id, $batch_ids)) {
                $isUniqueBatch = false;
            }
            array_push($batch_ids, $announcement->batch_id);
        }

        $this->assertTrue($isUniqueBatch);
    }

    /**
     * @test
     */
    public function adminCanUpdateAnnouncement()
    {
        $this->asAdmin();

        // Find random notifications
        $notification = \App\Models\Notification::orderByRaw('RAND()')->first();

        $topic = $this->faker->randomElement(['Announcement', 'Updates']);
        $content = $this->faker->sentences(3, true);
        $start_date = $this->faker->dateTimeBetween('now', '+2 day','Asia/Manila')->format('Y-m-d H:i:s');
        $end_date = $this->faker->dateTimeBetween('+2 weeks', '+1 month','Asia/Manila')->format('Y-m-d H:i:s');

        $response = $this->json('POST', route('api.admin.announcement.update', ['batch_id' => $notification->batch_id]), [
            'topic' => $topic,
            'content' => $content,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $response
            ->assertStatus(self::RESPONSE_SUCCESS)
            ->assertJson([
                'success' => true,
                'message' => trans('message.admin.announcement.success.update'),
            ]);

        $data = $response->getData();

        $this->assertEquals($notification->batch_id, $data->batch_id);

        // Check announcement are edited
        $announcementsDB = \App\Models\Notification::where('batch_id', $data->batch_id)->get();
        foreach ($announcementsDB as $announcement) {
            $announcement_data = $announcement->data;
            $this->assertEquals($announcement_data['topic'], $topic);
            $this->assertEquals($announcement_data['content'], $content);
            $this->assertEquals($announcement_data['start_date'], $start_date);
            $this->assertEquals($announcement_data['end_date'], $end_date);
        }

    }
}
