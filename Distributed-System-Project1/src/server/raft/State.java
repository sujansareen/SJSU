package server.raft;


import pipe.common.Common.Request;
import pipe.common.Common.WriteBody;
import pipe.work.Work.WorkMessage;


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
	/* Messages */
	public String handleMessageGet(String key) {
		return null;
	}
	public String handleMessagePost(String message, String toId,String fromId) {
		return null;
	}
	public void handleMessagePut(String message, String toId,String fromId) {
	}
	public void handleMessageDelete(String key) {
	}
	/* Groups */
	public String handleGroupPost(String fromId) {
		return null;
	}
	public void handleGroupPut(String groupId, String addUserId) {
	}
	public void handleGroupDelete(String groupId) {
	}
	/* Users */
	public String handleUserPost(String uname, String email, String password) {
		return null;
	}
	public void handleUserPut(String uname, String email, String password) {
	}
	public void handleUserDelete(String uname) {
	}
	/*  */
	public void sendAppendEntries(WriteBody wm) {
	}

	public void handleWriteFile(WriteBody msg) {
	}


}
