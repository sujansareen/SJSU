#!/bin/bash
#
# build the protobuf classes from the .proto. Note tested with 
# protobuf 2.4.1. Current version is 2.5.0.
#
# Building: 
# 
# Running this script is only needed when the protobuf structures 
# have change.
#

project_base="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# which protoc that you built (if not in your path)
#PROTOC_HOME=/usr/local/protobuf-2.5.0/

if [ -d ${project_base}/generated ]; then
  echo "removing contents of ${project_base}/generated"
  rm -r ${project_base}/generated/*
else
  echo "creating directory ${project_base}/generated"
  mkdir ${project_base}/generated
fi


protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/common.proto
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/election.proto
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/work.proto

protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/pipe.proto


# Resolve Import Files 
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/AppendEntriesRPC.proto
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/HeartBeatRPC.proto
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/VoteRPC.proto
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/Ping.proto

protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/imageTransfer.proto
protoc --proto_path=${project_base}/proto --java_out=${project_base}/generated ${project_base}/proto/monitor.proto

