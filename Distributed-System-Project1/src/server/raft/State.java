package server.raft;


import pipe.common.Common.Request;
import pipe.common.Common.WriteBody;
import pipe.work.Work.WorkMessage;
import routing.MsgInterface.Route;

import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;


/**
 * State pattern : Abstract class for leader , follower , candidate 
 *
 */
public class State {
	
	

	protected volatile Boolean running = Boolean.TRUE;
	static Thread cthread;
	
	public void startService(State state) {

	}

	public void stopService() {
	}

	public void handleResponseVoteRPCs(WorkMessage workMessage) {
		// TODO Auto-generated method stub

	}

	public WorkMessage handleRequestVoteRPC(WorkMessage workMessage) {
		// TODO Auto-generated method stub
		return null;
	}

	public void sendHeartBeat() {

	}

	public void handleHeartBeat(WorkMessage wm) {

	}
	
	public void handleHeartBeatResponse(WorkMessage wm) {

	}

	public void handleAppendEntries(WorkMessage wm) {

	}
	public void handleMessageEntries(Route rm) {

	}
	public void handleUserEntries(Route rm) {

	}
	public void handleNetworkDiscoveryPacketEntries(Route rm) {

	}
	
	/* Images */
	public byte[] handleGetMessage(String key) {
		return new byte[1];
	}
	
	public String handlePostMessage(byte[] image, long timestamp) {
		return null;
	}

	public void handlePutMessage(String key, byte[] image, long timestamp) {
	}
	
	public void handleDelete(String key) {
	}
	/*  */
	public void sendAppendEntries(WriteBody wm) {
	}

	public void handleWriteFile(WriteBody msg) {
	}
	
	public void handleReplicationMessage(Route msg) {
		
	}
	
	public void sendReplicationMessage() {
		
	}
}
