<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\Plan;
use Tests\TestCase;

class SushiManyToManyTest extends TestCase
{
    public function test__discount_pivot__returns_pivot_rows()
    {
        $this->assertCount(2, Discount::findOrFail(1)->pivot);
    }

    public function test__plan_pivot__returns_pivot_rows()
    {
        $this->assertCount(2, Plan::findOrFail(1)->pivot);
    }

    public function test__plan_with_pivot_and_nested_discount__returns_expected_data()
    {
        $expectedJSON = <<<JSON
[
  {
    "id": 1,
    "name": "SAAS Plus",
    "pivot": [
      {
        "discount_id": "1",
        "plan_id": "1",
        "discount": {
          "id": 1,
          "name": "Summer Sale"
        }
      },
      {
        "discount_id": "2",
        "plan_id": "1",
        "discount": {
          "id": 2,
          "name": "Black Friday"
        }
      }
    ]
  },
  {
    "id": 2,
    "name": "SAAS Premium",
    "pivot": [
      {
        "discount_id": "1",
        "plan_id": "2",
        "discount": {
          "id": 1,
          "name": "Summer Sale"
        }
      }
    ]
  }
]
JSON;

        $this->assertSame(
            json_decode($expectedJSON, true),
            Plan::with('pivot.discount')->get()->toArray()
        );
    }

    /**
     * Fails with:
     *
     * SQLSTATE[HY000]: General error: 1 no such table: discount_plan (SQL: select "plans".*,
     * "discount_plan"."discount_id" as "pivot_discount_id", "discount_plan"."plan_id" as "pivot_plan_id" from "plans"
     * inner join "discount_plan" on "plans"."id" = "discount_plan"."plan_id" where "discount_plan"."discount_id" = 1)
     */
    public function test__discount_plans__returns_plans()
    {
        $this->assertCount(2, Discount::findOrFail(1)->plans);
    }

    /**
     * Fails with:
     *
     * SQLSTATE[HY000]: General error: 1 no such table: discount_plan (SQL: select "discounts".*,
     * "discount_plan"."plan_id" as "pivot_plan_id", "discount_plan"."discount_id" as "pivot_discount_id" from
     * "discounts" inner join "discount_plan" on "discounts"."id" = "discount_plan"."discount_id" where
     * "discount_plan"."plan_id" = 1)
     */
    public function test__plan_discounts__returns_discounts()
    {
        $this->assertCount(2, Plan::findOrFail(1)->discounts);
    }
}
