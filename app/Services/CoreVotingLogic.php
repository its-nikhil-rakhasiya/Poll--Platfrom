<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use PDO;

class CoreVotingLogic
{
    /**
     * Check if an IP has already voted for a specific poll.
     * Uses raw SQL to simulate 'Core PHP' logic requirement.
     */
    public function checkVoteAllowed($pollId, $ipAddress)
    {
        // Using Laravel's PDO instance to run raw queries
        $pdo = DB::connection()->getPdo();
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE poll_id = :poll_id AND ip_address = :ip_address AND status = 'active'");
        $stmt->execute(['poll_id' => $pollId, 'ip_address' => $ipAddress]);
        
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false; // Vote blocked
        }

        return true; // Vote allowed
    }

    /**
     * Cast a vote using raw SQL.
     */
    public function castVote($pollId, $optionId, $ipAddress, $userId = null)
    {
        $pdo = DB::connection()->getPdo();
        
        $stmt = $pdo->prepare("INSERT INTO votes (poll_id, option_id, ip_address, user_id, status, created_at, updated_at) VALUES (:poll_id, :option_id, :ip_address, :user_id, 'active', NOW(), NOW())");
        
        return $stmt->execute([
            'poll_id' => $pollId,
            'option_id' => $optionId,
            'ip_address' => $ipAddress,
            'user_id' => $userId
        ]);
    }

    /**
     * Release an IP call (Module 4)
     * Updates status to 'released' and sets timestamp.
     */
    public function releaseIp($pollId, $ipAddress)
    {
        $pdo = DB::connection()->getPdo();
        
        $stmt = $pdo->prepare("UPDATE votes SET status = 'released', released_at = NOW() WHERE poll_id = :poll_id AND ip_address = :ip_address AND status = 'active'");
        
        return $stmt->execute([
            'poll_id' => $pollId,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Get vote history for a poll (Module 4)
     */
    public function getVoteHistory($pollId)
    {
        $pdo = DB::connection()->getPdo();
        
        $stmt = $pdo->prepare("
            SELECT v.*, po.option_text, u.name as user_name 
            FROM votes v 
            JOIN poll_options po ON v.option_id = po.id 
            LEFT JOIN users u ON v.user_id = u.id
            WHERE v.poll_id = :poll_id 
            ORDER BY v.created_at DESC
        ");
        $stmt->execute(['poll_id' => $pollId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
